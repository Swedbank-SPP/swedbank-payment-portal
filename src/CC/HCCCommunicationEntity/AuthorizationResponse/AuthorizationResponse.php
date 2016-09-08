<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse;

use SwedbankPaymentPortal\CC\Type\AuthorizationStatus;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction;
use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\AbstractResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;

/**
 * The container for the XML response.
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
class AuthorizationResponse extends AbstractResponse
{
    /**
     * API version used.
     *
     * @var int
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("integer")
     */
    private $version;

    /**
     * The acquirer to whom the transaction will be routed.
     *
     * @var string
     *
     * @Annotation\SerializedName("acquirer")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $acquirer;

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
     * The Merchant ID used to process the transaction.
     *
     * @var string
     *
     * @Annotation\SerializedName("mid")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $mid;

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
     * @var AuthorizationStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\Type\AuthorizationStatus")
     */
    private $status;

    /**
     * The container for the card transaction dtails.
     *
     * @var CardTxn
     *
     * @Annotation\SerializedName("CardTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse\CardTxn")
     */
    private $cardTxn;

    /**
     * AuthorizationResponse constructor.
     *
     * @param string              $version
     * @param string              $acquirer
     * @param string              $dataCashReference
     * @param string              $merchantReference
     * @param string              $mid
     * @param MerchantMode        $mode
     * @param string              $reason
     * @param AuthorizationStatus $status
     * @param int                 $time
     * @param CardTxn             $cardTxn
     */
    public function __construct(
        $version,
        $acquirer,
        $dataCashReference,
        $merchantReference,
        $mid,
        MerchantMode $mode,
        $reason,
        AuthorizationStatus $status,
        $time,
        CardTxn $cardTxn
    ) {
        parent::__construct($reason, $time);
        $this->version = $version;
        $this->acquirer = $acquirer;
        $this->dataCashReference = $dataCashReference;
        $this->merchantReference = $merchantReference;
        $this->mid = $mid;
        $this->mode = $mode;
        $this->status = $status;
        $this->cardTxn = $cardTxn;
    }

    /**
     * Version getter.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Version setter.
     *
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Acquirer getter.
     *
     * @return string
     */
    public function getAcquirer()
    {
        return $this->acquirer;
    }

    /**
     * Acquirer setter.
     *
     * @param string $acquirer
     */
    public function setAcquirer($acquirer)
    {
        $this->acquirer = $acquirer;
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
     * Mid getter.
     *
     * @return string
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * Mid setter.
     *
     * @param string $mid
     */
    public function setMid($mid)
    {
        $this->mid = $mid;
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
     * @return AuthorizationStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status setter.
     *
     * @param AuthorizationStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * CardTxn getter.
     *
     * @return CardTxn
     */
    public function getCardTxn()
    {
        return $this->cardTxn;
    }

    /**
     * CardTxn setter.
     *
     * @param CardTxn $cardTxn
     */
    public function setCardTxn($cardTxn)
    {
        $this->cardTxn = $cardTxn;
    }
}
