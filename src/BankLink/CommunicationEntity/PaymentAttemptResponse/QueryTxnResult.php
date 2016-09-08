<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\APMTxn;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;

/**
 * Class QueryTxnResult.
 *
 * @Annotation\AccessType("public_method")
 */
class QueryTxnResult
{
    /**
     * The container for the APM transaction
     *
     * @var APMTxn
     *
     * @Annotation\SerializedName("APMTxn")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\APMTxn")
     */
    private $apmTxn;

    /**
     * A 16 digit unique identifier for the transaction.
     * This reference will be used when submitting QUERY transactions to the Payment Gateway.
     *
     * @var string
     *
     * @Annotation\SerializedName("datacash_reference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $dataCashReference;

    /**
     * The unique reference for each transaction which is echoed from the Purchase Request.
     *
     * @var string
     *
     * @Annotation\SerializedName("merchant_reference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $merchantReference;

    /**
     * A descriptor relating to the state of the transaction.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $reason;

    /**
     * A numeric status code.
     *
     * @var PurchaseStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus")
     */
    private $status;

    /**
     * The time and date of the transaction.
     *
     * @var \DateTime
     *
     * @Annotation\Type("DateTime<'Y-m-d H:i:s'>")
     * @Annotation\SerializedName("transaction_date")
     * @Annotation\XmlElement(cdata=false)
     */
    private $transactionDate;

    /**
     * QueryTxnResult constructor.
     *
     * @param APMTxn         $apmTxn
     * @param string         $dataCashReference
     * @param string         $merchantReference
     * @param string         $reason
     * @param PurchaseStatus $status
     * @param \DateTime      $transactionDate
     */
    public function __construct(
        APMTxn $apmTxn,
        $dataCashReference,
        $merchantReference,
        $reason,
        PurchaseStatus $status,
        \DateTime $transactionDate
    ) {
        $this->apmTxn = $apmTxn;
        $this->dataCashReference = $dataCashReference;
        $this->merchantReference = $merchantReference;
        $this->reason = $reason;
        $this->status = $status;
        $this->transactionDate = $transactionDate;
    }

    /**
     * ApmTxn getter.
     *
     * @return APMTxn
     */
    public function getApmTxn()
    {
        return $this->apmTxn;
    }

    /**
     * ApmTxn setter.
     *
     * @param APMTxn $apmTxn
     */
    public function setApmTxn($apmTxn)
    {
        $this->apmTxn = $apmTxn;
    }

    /**
     * DataCashReference getter.
     *
     * @return string
     */
    public function getDataCashReference()
    {
        return $this->dataCashReference;
    }

    /**
     * DataCashReference setter.
     *
     * @param string $dataCashReference
     */
    public function setDataCashReference($dataCashReference)
    {
        $this->dataCashReference = $dataCashReference;
    }

    /**
     * MerchantReference getter.
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * MerchantReference setter.
     *
     * @param string $merchantReference
     */
    public function setMerchantReference($merchantReference)
    {
        $this->merchantReference = $merchantReference;
    }

    /**
     * Reason getter.
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Reason setter.
     *
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Status getter.
     *
     * @return PurchaseStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status setter.
     *
     * @param PurchaseStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * TransactionDate getter.
     *
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * TransactionDate setter.
     *
     * @param \DateTime $transactionDate
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
    }
}
