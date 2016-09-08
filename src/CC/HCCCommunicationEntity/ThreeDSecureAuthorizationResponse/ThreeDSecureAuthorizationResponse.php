<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse;

use JMS\Serializer\Annotation as Annotation;
use SwedbankPaymentPortal\CC\Type\ThreeDAuthorizationStatus;
use SwedbankPaymentPortal\SharedEntity\AbstractResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;

/**
 * The container for the XML response.
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
class ThreeDSecureAuthorizationResponse extends AbstractResponse
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
     * The container for the card transaction details.
     *
     * @var CardTxn
     *
     * @Annotation\SerializedName("CardTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\CardTxn")
     */
    private $cardTxn;

    /**
     * The container for the card transaction details.
     *
     * @var MAC
     *
     * @Annotation\SerializedName("MAC")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\MAC")
     */
    private $mac;

    /**
     * The container for the.
     *
     * @var Risk
     *
     * @Annotation\SerializedName("Risk")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\Risk")
     */
    private $risk;

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
     * Extended response message.
     *
     * @var string
     *
     * @Annotation\SerializedName("extended_response_message")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $extendedResponseMessage;

    /**
     * Extended status.
     *
     * @var string
     *
     * @Annotation\SerializedName("extended_status")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $extendedStatus;

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
     * Any other return code should be treated as a declined / failed payment.
     *
     * This is the ultimate field that should be used to determine the status of the transaction.
     *
     * @var ThreeDAuthorizationStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\Type\ThreeDAuthorizationStatus")
     */
    private $status;

    /**
     * ThreeDSecureAuthorizationResponse constructor.
     *
     * @param int                       $version
     * @param CardTxn                   $cardTxn
     * @param MAC                       $mac
     * @param Risk                      $risk
     * @param string                    $acquirer
     * @param string                    $dataCashReference
     * @param string                    $extendedResponseMessage
     * @param string                    $extendedStatus
     * @param string                    $merchantReference
     * @param string                    $mid
     * @param MerchantMode              $mode
     * @param string                    $reason
     * @param ThreeDAuthorizationStatus $status
     * @param int                       $time
     */
    public function __construct(
        $version,
        CardTxn $cardTxn,
        MAC $mac,
        Risk $risk,
        $acquirer,
        $dataCashReference,
        $extendedResponseMessage,
        $extendedStatus,
        $merchantReference,
        $mid,
        MerchantMode $mode,
        $reason,
        ThreeDAuthorizationStatus $status,
        $time
    ) {
        parent::__construct($reason, $time);
        $this->risk = $risk;
        $this->version = $version;
        $this->cardTxn = $cardTxn;
        $this->mac = $mac;
        $this->acquirer = $acquirer;
        $this->dataCashReference = $dataCashReference;
        $this->extendedResponseMessage = $extendedResponseMessage;
        $this->extendedStatus = $extendedStatus;
        $this->merchantReference = $merchantReference;
        $this->mid = $mid;
        $this->mode = $mode;
        $this->status = $status;
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
     * @return ThreeDAuthorizationStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status setter.
     *
     * @param ThreeDAuthorizationStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Risk getter.
     *
     * @return Risk
     */
    public function getRisk()
    {
        return $this->risk;
    }

    /**
     * Risk setter.
     *
     * @param Risk $risk
     */
    public function setRisk($risk)
    {
        $this->risk = $risk;
    }

    /**
     * ExtendedResponseMessage getter.
     *
     * @return string
     */
    public function getExtendedResponseMessage()
    {
        return $this->extendedResponseMessage;
    }

    /**
     * ExtendedResponseMessage setter.
     *
     * @param string $extendedResponseMessage
     */
    public function setExtendedResponseMessage($extendedResponseMessage)
    {
        $this->extendedResponseMessage = $extendedResponseMessage;
    }

    /**
     * ExtendedStatus getter.
     *
     * @return string
     */
    public function getExtendedStatus()
    {
        return $this->extendedStatus;
    }

    /**
     * ExtendedStatus setter.
     *
     * @param string $extendedStatus
     */
    public function setExtendedStatus($extendedStatus)
    {
        $this->extendedStatus = $extendedStatus;
    }

    /**
     * Mac getter.
     *
     * @return MAC
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Mac setter.
     *
     * @param MAC $mac
     */
    public function setMac($mac)
    {
        $this->mac = $mac;
    }
}
