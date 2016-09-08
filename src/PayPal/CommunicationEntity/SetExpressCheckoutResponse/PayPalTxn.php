<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\PayPal\Type\AcknowledgmentStatus;

/**
 * The container for the paypal info.
 *
 * @Annotation\AccessType("public_method")
 */
class PayPalTxn
{
    /**
     * Acknowledgement status.
     *
     * @var AcknowledgmentStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\PayPal\Type\AcknowledgmentStatus")
     * @Annotation\SerializedName("ack")
     */
    private $acknowledgment;

    /**
     * PayPal build version.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $build;

    /**
     * PayPal transaction reference.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("correlationid")
     */
    private $correlationId;

    /**
     * Date and time that the requested API operation was performed.
     *
     * @var \DateTime
     *
     * @Annotation\Type("DateTime<'Y-m-d\TH:i:s\Z'>")
     * @Annotation\XmlElement(cdata=false)
     */
    private $timestamp;

    /**
     * Token.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $token;

    /**
     * PayPal version.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $version;

    /**
     * PayPalTxn constructor.
     *
     * @param AcknowledgmentStatus $acknowledgment
     * @param string               $build
     * @param string               $correlationId
     * @param \DateTime            $timestamp
     * @param string               $token
     * @param string               $version
     */
    public function __construct(
        AcknowledgmentStatus $acknowledgment,
        $build,
        $correlationId,
        \DateTime $timestamp,
        $token,
        $version
    ) {
        $this->acknowledgment = $acknowledgment;
        $this->build = $build;
        $this->correlationId = $correlationId;
        $this->timestamp = $timestamp;
        $this->token = $token;
        $this->version = $version;
    }

    /**
     * Acknowledgment getter.
     *
     * @return AcknowledgmentStatus
     */
    public function getAcknowledgment()
    {
        return $this->acknowledgment;
    }

    /**
     * Acknowledgment setter.
     *
     * @param AcknowledgmentStatus $acknowledgment
     */
    public function setAcknowledgment($acknowledgment)
    {
        $this->acknowledgment = $acknowledgment;
    }

    /**
     * Build getter.
     *
     * @return string
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * Build setter.
     *
     * @param string $build
     */
    public function setBuild($build)
    {
        $this->build = $build;
    }

    /**
     * CorrelationId getter.
     *
     * @return string
     */
    public function getCorrelationId()
    {
        return $this->correlationId;
    }

    /**
     * CorrelationId setter.
     *
     * @param string $correlationId
     */
    public function setCorrelationId($correlationId)
    {
        $this->correlationId = $correlationId;
    }

    /**
     * Timestamp getter.
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Timestamp setter.
     *
     * @param \DateTime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Token getter.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Token setter.
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Version getter.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Version setter.
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
}
