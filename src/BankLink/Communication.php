<?php

namespace SwedbankPaymentPortal\BankLink;

use SwedbankPaymentPortal\AbstractCommunication;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest\HPSQueryRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptRequest\PaymentAttemptRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\PaymentAttemptResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\PurchaseRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseResponse\PurchaseResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\TransactionQueryRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryResponse\TransactionQueryResponse;
use SwedbankPaymentPortal\SharedEntity\Type\TransportType;

/**
 * Handles communication with guzzle.
 */
class Communication extends AbstractCommunication
{
    /**
     * Sends a purchase request.
     *
     * @param PurchaseRequest $purchaseRequest
     *
     * @return PurchaseResponse
     */
    public function sendPurchaseRequest(PurchaseRequest $purchaseRequest)
    {
        return $this->sendDataToNetwork(
            $purchaseRequest,
            PurchaseResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::purchase()
        );
    }

    /**
     * Sends a Transaction query request.
     *
     * @param TransactionQueryRequest $transactionQueryRequest
     *
     * @return TransactionQueryResponse
     */
    public function sendTransactionQueryRequest(TransactionQueryRequest $transactionQueryRequest)
    {
        return $this->sendDataToNetwork(
            $transactionQueryRequest,
            TransactionQueryResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::transactionQuery()
        );
    }

    /**
     * Sends a hps query request.
     *
     * @param HPSQueryRequest $hpsQueryRequest
     *
     * @return HPSQueryResponse
     */
    public function sendHPSQueryRequest(HPSQueryRequest $hpsQueryRequest)
    {
        return $this->sendDataToNetwork(
            $hpsQueryRequest,
            HPSQueryResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::hpsQuery()
        );
    }

    /**
     * Sends a hps query request.
     *
     * @param PaymentAttemptRequest $paymentAttemptRequest
     *
     * @return PaymentAttemptResponse
     */
    public function sendPaymentAttemptRequest(PaymentAttemptRequest $paymentAttemptRequest)
    {
        return $this->sendDataToNetwork(
            $paymentAttemptRequest,
            PaymentAttemptResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::paymentAttempt()
        );
    }
}
