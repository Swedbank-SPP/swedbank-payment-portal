<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\AbstractResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;

/**
 * The container for the XML request.
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
class HPSQueryResponse extends AbstractResponse
{
    /**
     * The container for the HPS (hosted page) details.
     *
     * @var HpsTxn
     *
     * @Annotation\SerializedName("HpsTxn")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HpsTxn")
     */
    private $hpsTxn;

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
     * @Annotation\SerializedName("merchantreference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $merchantReference;

    /**
     * Provides additional information on the status of the queried transaction.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $information;

    /**
     * Indicates if simulators have been used or a payment provider has been contacted.
     *
     * @var MerchantMode
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\MerchantMode")
     */
    private $mode;

    /**
     * A numeric status code.
     *
     * @var PurchaseStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus")
     */
    private $status;

    /**
     * PurchaseResponse constructor.
     *
     * @param HpsTxn         $hpsTxn
     * @param string         $merchantReference
     * @param string         $dataCashReference
     * @param MerchantMode   $mode
     * @param string         $information
     * @param string         $reason
     * @param PurchaseStatus $status
     * @param int            $time
     */
    public function __construct(
        HpsTxn $hpsTxn,
        $merchantReference,
        $dataCashReference,
        MerchantMode $mode,
        $information,
        $reason,
        PurchaseStatus $status,
        $time
    ) {
        parent::__construct($reason, $time);
        $this->hpsTxn = $hpsTxn;
        $this->merchantReference = $merchantReference;
        $this->dataCashReference = $dataCashReference;
        $this->mode = $mode;
        $this->information = $information;
        $this->status = $status;
    }

    /**
     * HpsTxn getter.
     *
     * @return HpsTxn
     */
    public function getHpsTxn()
    {
        return $this->hpsTxn;
    }

    /**
     * HpsTxn setter.
     *
     * @param HpsTxn $hpsTxn
     */
    public function setHpsTxn($hpsTxn)
    {
        $this->hpsTxn = $hpsTxn;
    }

    /**
     * DataCashReference getter.
     *
     * @return int
     */
    public function getDataCashReference()
    {
        return $this->dataCashReference;
    }

    /**
     * DataCashReference setter.
     *
     * @param int $dataCashReference
     */
    public function setDataCashReference($dataCashReference)
    {
        $this->dataCashReference = $dataCashReference;
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
     * Information getter.
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Information setter.
     *
     * @param string $information
     */
    public function setInformation($information)
    {
        $this->information = $information;
    }
}
