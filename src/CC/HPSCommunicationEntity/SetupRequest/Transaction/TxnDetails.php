<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;
use SwedbankPaymentPortal\CC\Validator;
use SwedbankPaymentPortal\SharedEntity\Amount;

/**
 * The container for the transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class TxnDetails
{
    /**
     * @const Ecomm is used for website / Internet / mobile environments.
     */
    const CAPTURE_METHOD_DEFAULT = 'ecomm';

    /**
     * The container that contains the data to be risk screened.
     *
     * @var Risk
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\Risk")
     * @Annotation\SerializedName("Risk")
     */
    private $risk;

    /**
     * The unique reference for each transaction which is echoed from the request.
     *
     * @var string
     *
     * @Annotation\SerializedName("merchantreference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $merchantReference;

    /**
     * The container for 3-D Secure details.
     *
     * @var ThreeDSecure
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\ThreeDSecure")
     * @Annotation\SerializedName("ThreeDSecure")
     */
    private $threeDSecure;

    /**
     * Indicates the environment from which the transaction has been processed.
     *
     * For example, ecomm is used for website / Internet / mobile environments.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("capturemethod")
     * @Annotation\Type("string")
     */
    private $captureMethod = self::CAPTURE_METHOD_DEFAULT;

    /**
     * The amount to be authorized and an indication of the currency to be used. EUR only.
     *
     * @var Amount
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Amount")
     * @Annotation\SerializedName("amount")
     */
    private $amount;

    /**
     * TxnDetails constructor.
     *
     * @param Action       $action
     * @param string       $merchantReference
     * @param Amount       $amount
     * @param ThreeDSecure $threeDSecure
     * @param string       $captureMethod
     */
    public function __construct(
        Action $action,
        $merchantReference,
        Amount $amount,
        ThreeDSecure $threeDSecure,
        $captureMethod = self::CAPTURE_METHOD_DEFAULT
    ) {
        $this->risk = new Risk($action);
        $this->setMerchantReference($merchantReference);
        $this->amount = $amount;
        $this->threeDSecure = $threeDSecure;
        $this->captureMethod = $captureMethod;
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
     * @throws \RuntimeException
     */
    public function setMerchantReference($merchantReference)
    {
        Validator::merchantReferenceMustBeValid($merchantReference);

        $this->merchantReference = $merchantReference;
    }

    /**
     * Amount getter.
     *
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Amount setter.
     *
     * @param Amount $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * ThreeDSecure getter.
     *
     * @return ThreeDSecure
     */
    public function getThreeDSecure()
    {
        return $this->threeDSecure;
    }

    /**
     * ThreeDSecure setter.
     *
     * @param ThreeDSecure $threeDSecure
     */
    public function setThreeDSecure($threeDSecure)
    {
        $this->threeDSecure = $threeDSecure;
    }

    /**
     * CaptureMethod getter.
     *
     * @return string
     */
    public function getCaptureMethod()
    {
        return $this->captureMethod;
    }

    /**
     * CaptureMethod setter.
     *
     * @param string $captureMethod
     */
    public function setCaptureMethod($captureMethod)
    {
        $this->captureMethod = $captureMethod;
    }
}
