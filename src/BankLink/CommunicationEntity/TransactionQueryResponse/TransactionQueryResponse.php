<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryResponse;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\APMTxn;
use SwedbankPaymentPortal\SharedEntity\AbstractResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;

/**
 * The container for the response XML.
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
class TransactionQueryResponse extends AbstractResponse
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
     * A numeric status code.
     *
     * @var ResponseStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus")
     */
    private $status;

    /**
     * Indicates if simulators have been used or a payment provider has been contacted.
     *
     * @var MerchantMode
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\MerchantMode")
     */
    private $mode;

    /**
     * The time and date of the transaction.
     *
     * @var \DateTime
     *
     * @Annotation\Type("DateTime<'U'>")
     * @Annotation\SerializedName("time")
     * @Annotation\XmlElement(cdata=false)
     */
    protected $time;

    /**
     * TransactionQueryResponse constructor.
     *
     * @param APMTxn         $apmTxn
     * @param string         $dataCashReference
     * @param string         $merchantReference
     * @param string         $reason
     * @param ResponseStatus $status
     * @param MerchantMode   $mode
     * @param \DateTime      $time
     */
    public function __construct(
        APMTxn $apmTxn,
        $dataCashReference,
        $merchantReference,
        $reason,
        ResponseStatus $status,
        MerchantMode $mode,
        \DateTime $time
    ) {
        parent::__construct($reason, $time);
        $this->apmTxn = $apmTxn;
        $this->dataCashReference = $dataCashReference;
        $this->merchantReference = $merchantReference;
        $this->status = $status;
        $this->mode = $mode;
    }

    /**
     * Time getter.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Time setter.
     *
     * @param \DateTime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
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
     * Status getter.
     *
     * @return ResponseStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status setter.
     *
     * @param ResponseStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Mode getter.
     *
     * @return MerchantMode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Mode setter.
     *
     * @param MerchantMode $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }
}
