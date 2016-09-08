<?php

namespace SwedbankPaymentPortal\PayPal;

use SwedbankPaymentPortal\AbstractService;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentRequest\DoExpressCheckoutPaymentRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentResponse\DoExpressCheckoutPaymentResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\GetExpressCheckoutDetailsRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\Transaction;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentRequest\Transaction as DoTransaction;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse\GetExpressCheckoutDetailsResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\SetExpressCheckoutRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse\SetExpressCheckoutResponse;
use SwedbankPaymentPortal\PayPal\Type\PaymentStatus;
use SwedbankPaymentPortal\Transaction\TransactionContainer;
use SwedbankPaymentPortal\Transaction\TransactionFrame;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;

/**
 * PayPalService handles purchases over PayPal Express Checkout
 */
class PayPalService extends AbstractService
{
    /**
     * @var Communication
     */
    protected $communication;
    
    /**
     * Handles and starts a purchase.
     *
     * @param SetExpressCheckoutRequest $setupRequest
     * @param CallbackInterface         $finalCallback
     *
     * @return SetExpressCheckoutResponse
     */
    public function initPayment(SetExpressCheckoutRequest $setupRequest, CallbackInterface $finalCallback)
    {
        $setupRequest->setAuthentication($this->serviceOptions->getAuthentication());
        $transactionFrame = new TransactionFrame($setupRequest);
        $response = $this->communication->sendSetupRequest($setupRequest);
        $transactionFrame->setResponse($response);

        $transactionContainer = new TransactionContainer(
            $setupRequest->getTransaction()->getTxnDetails()->getMerchantReference(),
            $finalCallback
        );
        $transactionContainer->setPendingResult(true);
        $transactionContainer->addFrame($transactionFrame);
        $this->getTransactionRepository()->persist($transactionContainer);

        return $response;
    }

    /**
     * Continues with a details query.
     *
     * @param string $merchantReference
     *
     * @return GetExpressCheckoutDetailsResponse
     */
    public function getTransactionInfo($merchantReference)
    {
        $transactionContainer = $this->getTransactionRepository()->get($merchantReference);

        $frames = $transactionContainer->getFrames();
        
        /** @var SetExpressCheckoutResponse $lastResponse */
        $lastResponse = reset($frames)->getResponse();

        $payPalTxn = new Transaction\PayPalTxn($lastResponse->getDataCashReference());

        // we need to add suffix '_req' to real reference id, as by SPP demo examples
        $txnDetails = new Transaction\TxnDetails(sprintf('%s_%03s_req', $merchantReference, time()%999));
        $transaction = new Transaction($txnDetails, $payPalTxn);
        $detailsQuery = new GetExpressCheckoutDetailsRequest($transaction, $this->serviceOptions->getAuthentication());
        $transactionFrame = new TransactionFrame($detailsQuery);

        /** @var GetExpressCheckoutDetailsResponse $response */
        $response = $this->communication->sendGetDetailsRequest($detailsQuery);
        $transactionFrame->setResponse($response);
        $transactionContainer->addFrame($transactionFrame);

        return $response;
    }

    /**
     * Finishes the query with a do expcress checkout request.
     *
     * @param string $merchantReference
     *
     * @return GetExpressCheckoutDetailsResponse
     */
    public function finishTransaction($merchantReference)
    {
        $transactionContainer = $this->getTransactionRepository()->get($merchantReference);

        /**
         * @var SetExpressCheckoutRequest  $lastRequest
         * @var SetExpressCheckoutResponse $lastResponse
         */
        $frames = $transactionContainer->getFrames();
        $lastResponse = reset($frames)->getResponse();
        $lastRequest = reset($frames)->getRequest();

        $payPalTxn = new DoTransaction\PayPalTxn(
            $lastRequest->getTransaction()->getPayPalTxn()->getShippingAddress(),
            $lastResponse->getDataCashReference()
        );
        $txnDetails = new DoTransaction\TxnDetails(
            $lastRequest->getTransaction()->getTxnDetails()->getAmount(),
            sprintf('%s_%03s_do', $merchantReference, time()%999) // we need to append suffix to merchant, as in SPP demo example.
        );
        $transaction = new DoTransaction($txnDetails, $payPalTxn);
        $request = new DoExpressCheckoutPaymentRequest($transaction, $this->serviceOptions->getAuthentication());
        $transactionFrame = new TransactionFrame($request);

        try {
            
            /** @var DoExpressCheckoutPaymentResponse $response */
            $response = $this->communication->sendDoCheckoutRequest($request);
            $transactionFrame->setResponse($response);

            $transactionResult = TransactionResult::failure();
            if ($response->getPayPalTxn()->getPaymentStatus() === PaymentStatus::completed()) {
                $transactionResult = TransactionResult::success();
            }

        $transactionContainer->getCallback()->handleFinishedTransaction($transactionResult, $transactionFrame);
        $this->getTransactionRepository()->remove($merchantReference);

            return $response;
        } catch (\Exception $e) {
            return null;
        }

    }

    /**
     * Forces a check on all pending transactions.
     */
    public function checkPendingTransactions()
    {
        foreach ($this->getTransactionRepository()->getPendingTransactions() as $transaction) {
            if ($this->shouldQueryTransaction($transaction)) {
                $this->finishTransaction($transaction->getKey());
            }
        }
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
     * @param string $merchantReference
     * @return GetExpressCheckoutDetailsResponse
     */
    public function handlePendingTransaction($merchantReference)
    {
        $this->getTransactionInfo($merchantReference);
        $response = $this->finishTransaction($merchantReference);

        return $response;
    }
}
