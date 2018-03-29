<?php

namespace SwedbankPaymentPortal\CC\HPSService;

use SwedbankPaymentPortal\AbstractService;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\CC\PaymentCardTransactionData;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryRequest\Transaction as HCCTransaction;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\HCCQueryResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryRequest\HPSQueryRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\ResponseStatus;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSCancelRequest\HPSCancelRequest as queryHPSCancelRequest;

use SwedbankPaymentPortal\CC\HPSCommunicationEntity\QueryRequest\QueryRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSRefundRequest\HPSRefundRequest;

use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupResponse\SetupResponse;
use SwedbankPaymentPortal\SharedEntity\HPSQueryRequest\Transaction;
use SwedbankPaymentPortal\SharedEntity\HPSCancelRequest\Transaction as cancelTrancsaction;
use SwedbankPaymentPortal\SharedEntity\HPSCancelRequest\Transaction\HistoricTxn as cancelHistoricTxn;

use SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction as queryTrancsaction;
use SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction\HistoricTxn as queryHistoricTxn;
use SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction\Reference;

use SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction as refundTrancsaction;
use SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction\HistoricTxn as refundHistoricTxn;
use SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction\TxnDetails;

use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;
use SwedbankPaymentPortal\Transaction\TransactionContainer;
use SwedbankPaymentPortal\Transaction\TransactionFrame;

/**
 * Service handling all of the payment card processes using HPS queries.
 */
class HPSService extends AbstractService
{
    /**
     * @var Communication
     */
    protected $communication;

    /**
     * Handles and starts a purchase.
     *
     * @param SetupRequest      $setupRequest
     * @param CallbackInterface $finalCallback
     *
     * @return SetupResponse
     */
    public function initPayment(SetupRequest $setupRequest, CallbackInterface $finalCallback)
    {
        $setupRequest->setAuthentication($this->serviceOptions->getAuthentication());
        $transactionFrame = new TransactionFrame($setupRequest);
        $response = $this->communication->sendSetupRequest($setupRequest);
        $transactionFrame->setResponse($response);

        $transactionContainer = new TransactionContainer(
            $setupRequest->getTransaction()->getTxnDetails()->getMerchantReference(),
            $finalCallback
        );
        $transactionContainer->addFrame($transactionFrame);
        $this->getTransactionRepository()->persist($transactionContainer);

        return $response;
    }

    /**
     * Handles unfinished transactions.
     *
     * Note: this library will handle all transaction logic automatically.
     * All information about transaction it's credit card details etc. will be passed to callback which
     * was defined during initPayment() call.
     *
     * Note2: after this method call transaction can still be left in unfinished state, so do not
     * forget to call checkPendingTransactions() in some cron job which tries to handle all pending unfinished transactions.
     *
     * Note3: Callback is called only when transaction is finished (e.g. it's status is SUCCESS or FAIL)
     *
     * Note4: If in some case you'll need only low level communication within SPP, you can use getCommunication() method
     * to get an underlying object which is responsible for low level communication and do SPP calls directly, but
     * doing that you'll get no benefits of SPP library itself (no transaction handling logic).
     *
     *
     * @param string $merchantReferenceId
     * @return TransactionResult
     */
    public function handlePendingTransaction($merchantReferenceId)
    {
        return $this->hpsQuery($merchantReferenceId);
    }

    /**
     * Handles unfinished transactions.
     *
     * Note: this library will handle all transaction logic automatically.
     * All information about transaction it's credit card details etc. will be passed to callback which
     * was defined during initPayment() call.
     *
     * Note2: after this method call transaction can still be left in unfinished state, so do not
     * forget to call checkPendingTransactions() in some cron job which tries to handle all pending unfinished transactions.
     *
     * Note3: Callback is called only when transaction is finished (e.g. it's status is SUCCESS or FAIL)
     *
     * Note4: If in some case you'll need only low level communication within SPP, you can use getCommunication() method
     * to get an underlying object which is responsible for low level communication and do SPP calls directly, but
     * doing that you'll get no benefits of SPP library itself (no transaction handling logic).
     *
     *
     * @param string $merchantReference
     * @return TransactionResult
     *
     * @deprecated use handlePendingTransaction(), this method will be removed in v1.0 version
     */
    public function hpsQuery($merchantReference)
    {
        $transactionContainer = $this->getTransactionRepository()->get($merchantReference);

        /** @var SetupResponse $lastResponse */
        $frames = $transactionContainer->getFrames();
        $lastResponse = reset($frames)->getResponse();

        $hpsQuery = new HPSQueryRequest(
            $this->serviceOptions->getAuthentication(),
            new Transaction(new Transaction\HistoricTxn($lastResponse->getDataCashReference()))
        );
        $transactionFrame = new TransactionFrame($hpsQuery);

        /** @var HPSQueryResponse $response */
        $response = $this->communication->sendHPSQueryRequest($hpsQuery);
        $transactionFrame->setResponse($response);
        $transactionContainer->addFrame($transactionFrame);

        $transactionResult = $this->handleHPSResponse($response);

        if ($transactionResult !== TransactionResult::unfinished()) {

            $this->getTransactionRepository()->remove($merchantReference);

            if ($transactionResult === TransactionResult::success()) {

                $response = $this->getTransactionInformation($response->getHpsTxn()->getAuthAttempts()[0]->getDataCashReference());

                $paymentCardTransactionData = PaymentCardTransactionData::createFromHCCQueryResponse($response);

                $transactionContainer->getCallback()->handleFinishedTransaction($transactionResult, $transactionFrame, $paymentCardTransactionData);
            } else {
                $transactionContainer->getCallback()->handleFinishedTransaction($transactionResult, $transactionFrame);
            }

        } else {
            $this->getTransactionRepository()->persist($transactionContainer);
        }

        return $transactionResult;
    }
    
    /**
     * Cancel transaction
     *
     *
     * @param string $merchantReference
     * @return TransactionResult
     */
    public function hpsCancel($merchantReference)
    {
        
        $histTx = new cancelHistoricTxn($merchantReference);
        
        $hpsCancelQuery = new queryHPSCancelRequest(
            $this->serviceOptions->getAuthentication(),
            new cancelTrancsaction($histTx)
        );
        
        /** @var HPSCancelResponse $response */
        $response = $this->communication->sendHPSCancelRequest($hpsCancelQuery);
        
        return $response;
    }
    
    /**
     * Refund transaction
     *
     *
     * @param string $reference
     * @param string $amount
     * @return TransactionResult
     */
    public function hpsRefund($reference, $amount)
    {
        
        $histTx = new refundHistoricTxn($reference);
        $txDetails = new TxnDetails($amount);
        
        $query = new HPSRefundRequest(
            $this->serviceOptions->getAuthentication(),
            new refundTrancsaction($histTx, $txDetails)
        );
        
        /** @var HPSRefundResponse $response */
        $response = $this->communication->sendHPSRefundRequest($query);
        
        return $response;
    }
    
    /**
     * Query transaction
     *
     *
     * @param string $merchantReference
     * @return TransactionResult
     */
    public function query($merchantReference)
    {
        
        $histTx = new queryHistoricTxn(new Reference($merchantReference));
        
        $Query = new QueryRequest(
            $this->serviceOptions->getAuthentication(),
            new queryTrancsaction($histTx)
        );
        
        /** @var QueryResponse $response */
        $response = $this->communication->sendQueryRequest($Query);

        return $response;
    }


    /**
     * @param $datacashReferenceId
     * @return HCCQueryResponse
     */
    private function getTransactionInformation($datacashReferenceId)
    {
        $hpsQuery = new HPSQueryRequest(
            $this->serviceOptions->getAuthentication(),
            new Transaction(new Transaction\HistoricTxn($datacashReferenceId))
        );

        /** @var HCCQueryResponse $response */
        $response = $this->communication->sendQueryAttemptRequest($hpsQuery);

        return $response;
    }


    /**
     * Forces a check on all pending transactions.
     * return an array of Exceptions occurred during process.
     * If everything was success array will be empty.
     * @return array
     */
    public function checkPendingTransactions()
    {
        $errors = [];

        $transactionRepository = $this->getTransactionRepository();

        foreach ($transactionRepository->getPendingTransactions() as $transaction) {
            if ($this->shouldQueryTransaction($transaction)) {
                if ($this->checkIfTransactionIsNotExpired($transaction)) {
                    $transaction->setLastQueryingTime(new \DateTime());
                    $transactionRepository->persist($transaction);

                    try {
                        $this->hpsQuery($transaction->getKey());
                    } catch (\Exception $e) {
                        $errors [] = $e;
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * @param TransactionContainer $transaction
     * @return bool
     */
    private function shouldQueryTransaction(TransactionContainer $transaction)
    {
        $transactionTime = $transaction->getLastQueryingTime()->getTimestamp();
        $timeout = $this->serviceOptions->getPendingTransactionQueryingInterval();

        return ((time() - $transactionTime) >= $timeout * 60.0);
    }

    /**
     * Handles hps request and removes cached data if it's finished.
     *
     * @param HPSQueryResponse $response
     *
     * @return TransactionResult
     */
    private function handleHPSResponse(HPSQueryResponse $response)
    {
        if ($response->getStatus() == PurchaseStatus::HpsSessionTimedOut()) {
            return TransactionResult::failure();
        }

        if (!$response->getHpsTxn() || count($response->getHpsTxn()->getAuthAttempts()) == 0) {
            return TransactionResult::unfinished();
        }

        $allFailed = true;
        foreach ($response->getHpsTxn()->getAuthAttempts() as $authAttempt) {
            if ($authAttempt->getDcResponse() == ResponseStatus::accepted()) {
                return TransactionResult::success();
            }
        }

        return $allFailed ? TransactionResult::failure() : TransactionResult::unfinished();
    }

}
