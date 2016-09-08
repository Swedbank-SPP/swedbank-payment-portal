<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\PurchaseRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\MethodDetails;
use JMS\Serializer\Annotation;

/**
 * The container for the alternative payment.
 *
 * @Annotation\AccessType("public_method")
 */
class AlternativePayment
{
    /**
     * The version used for the APM’s complex structure.
     *
     * @var string
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("string")
     * @Annotation\AccessType("reflection")
     */
    private $version = PurchaseRequest::API_VERSION;

    /**
     * The container for Swedbank transaction details.
     *
     * @var TransactionDetails
     *
     * @Annotation\SerializedName("TransactionDetails")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails")
     */
    private $transactionDetails;

    /**
     * The container for Swedbank-specific fields
     *
     * @var MethodDetails
     *
     * @Annotation\SerializedName("MethodDetails")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\MethodDetails")
     */
    private $methodDetails;

    /**
     * AlternativePayment constructor.
     *
     * @param TransactionDetails $transactionDetails
     * @param MethodDetails      $methodDetails
     */
    public function __construct(TransactionDetails $transactionDetails, MethodDetails $methodDetails)
    {
        $this->transactionDetails = $transactionDetails;
        $this->methodDetails = $methodDetails;
    }

    /**
     * TransactionDetails getter.
     *
     * @return TransactionDetails
     */
    public function getTransactionDetails()
    {
        return $this->transactionDetails;
    }

    /**
     * TransactionDetails setter.
     *
     * @param TransactionDetails $transactionDetails
     */
    public function setTransactionDetails($transactionDetails)
    {
        $this->transactionDetails = $transactionDetails;
    }

    /**
     * MethodDetails getter.
     *
     * @return MethodDetails
     */
    public function getMethodDetails()
    {
        return $this->methodDetails;
    }

    /**
     * MethodDetails setter.
     *
     * @param MethodDetails $methodDetails
     */
    public function setMethodDetails($methodDetails)
    {
        $this->methodDetails = $methodDetails;
    }
}
