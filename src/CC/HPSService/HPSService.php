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
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupResponse\SetupResponse;
use SwedbankPaymentPortal\SharedEntity\HPSQueryRequest\Transaction;
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
     * Continues with a hps query.
     *
     * @param string $merchantReference
     *
     * @return HPSQueryResponse
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

                $transaction->setLastQueryingTime(new \DateTime());
                $transactionRepository->persist($transaction);

                try {
                    $this->hpsQuery($transaction->getKey());
                } catch (\Exception $e) {
                    $errors [] = $e;
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
