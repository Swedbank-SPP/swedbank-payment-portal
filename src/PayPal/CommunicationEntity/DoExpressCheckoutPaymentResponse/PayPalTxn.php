<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentResponse;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\PayPal\Type\AcknowledgmentStatus;
use SwedbankPaymentPortal\PayPal\Type\PaymentStatus;

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
     * The final amount charged, including any shipping and taxes from your PayPal Merchant Profile.
     *
     * @var float
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("float")
     * @Annotation\SerializedName("amt")
     */
    private $amount;

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
     * The currency used in this payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("currencycode")
     */
    private $currencyCode;

    /**
     * Error code.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("errorcode")
     */
    private $errorCode;

    /**
     * Was insurance option selected.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("insuranceoptionselected")
     */
    private $insuranceOptionSelected;

    /**
     * When was the order placed.
     *
     * @var \DateTime
     *
     * @Annotation\Type("DateTime<'Y-m-d\TH:i:s\Z'>")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("ordertime")
     */
    private $orderTime;

    /**
     * Payment status.
     *
     * @var PaymentStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\PayPal\Type\PaymentStatus")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("paymentstatus")
     */
    private $paymentStatus;

    /**
     * Payment type.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("paymenttype")
     */
    private $paymentType;

    /**
     * Pending reason.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("pendingreason")
     */
    private $pendingReason;

    /**
     * Protection eligibility.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("protectioneligibility")
     */
    private $protectionEligibility;

    /**
     * Protection eligibility type.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("protectioneligibilitytype")
     */
    private $protectionEligibilityType;

    /**
     * Reason code.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("reasoncode")
     */
    private $reasonCode;

    /**
     * Secure Merchant Account Id.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("securemerchantaccountid")
     */
    private $secureMerchantAccountId;

    /**
     * Is shipping option default?
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("shippingoptionisdefault")
     */
    private $shippingOptionIsDefault;

    /**
     * Was success page redirect requested?
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("successpageredirectrequested")
     */
    private $successPageRedirectRequested;

    /**
     * Tax amount.
     *
     * @var float
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("float")
     * @Annotation\SerializedName("taxamt")
     */
    private $taxAmount;

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
     * Transaction id.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("transactionid")
     */
    private $transactionId;

    /**
     * Transaction type.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("transactiontype")
     */
    private $transactionType;

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
     * @param float                $amount
     * @param string               $build
     * @param string               $correlationId
     * @param string               $currencyCode
     * @param string               $errorCode
     * @param string               $insuranceOptionSelected
     * @param \DateTime            $orderTime
     * @param PaymentStatus        $paymentStatus
     * @param string               $paymentType
     * @param string               $pendingReason
     * @param string               $protectionEligibility
     * @param string               $protectionEligibilityType
     * @param string               $reasonCode
     * @param string               $secureMerchantAccountId
     * @param string               $shippingOptionIsDefault
     * @param string               $successPageRedirectRequested
     * @param float                $taxAmount
     * @param \DateTime            $timestamp
     * @param string               $token
     * @param string               $transactionId
     * @param string               $transactionType
     * @param string               $version
     */
    public function __construct(
        AcknowledgmentStatus $acknowledgment,
        $amount,
        $build,
        $correlationId,
        $currencyCode,
        $errorCode,
        $insuranceOptionSelected,
        \DateTime $orderTime,
        PaymentStatus $paymentStatus,
        $paymentType,
        $pendingReason,
        $protectionEligibility,
        $protectionEligibilityType,
        $reasonCode,
        $secureMerchantAccountId,
        $shippingOptionIsDefault,
        $successPageRedirectRequested,
        $taxAmount,
        \DateTime $timestamp,
        $token,
        $transactionId,
        $transactionType,
        $version
    ) {
        $this->acknowledgment = $acknowledgment;
        $this->amount = $amount;
        $this->build = $build;
        $this->correlationId = $correlationId;
        $this->currencyCode = $currencyCode;
        $this->errorCode = $errorCode;
        $this->insuranceOptionSelected = $insuranceOptionSelected;
        $this->orderTime = $orderTime;
        $this->paymentStatus = $paymentStatus;
        $this->paymentType = $paymentType;
        $this->pendingReason = $pendingReason;
        $this->protectionEligibility = $protectionEligibility;
        $this->protectionEligibilityType = $protectionEligibilityType;
        $this->reasonCode = $reasonCode;
        $this->secureMerchantAccountId = $secureMerchantAccountId;
        $this->shippingOptionIsDefault = $shippingOptionIsDefault;
        $this->successPageRedirectRequested = $successPageRedirectRequested;
        $this->taxAmount = $taxAmount;
        $this->timestamp = $timestamp;
        $this->token = $token;
        $this->transactionId = $transactionId;
        $this->transactionType = $transactionType;
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
     * Amount getter.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Amount setter.
     *
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
     * CurrencyCode getter.
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * CurrencyCode setter.
     *
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * ErrorCode getter.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * ErrorCode setter.
     *
     * @param string $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * InsuranceOptionSelected getter.
     *
     * @return string
     */
    public function getInsuranceOptionSelected()
    {
        return $this->insuranceOptionSelected;
    }

    /**
     * InsuranceOptionSelected setter.
     *
     * @param string $insuranceOptionSelected
     */
    public function setInsuranceOptionSelected($insuranceOptionSelected)
    {
        $this->insuranceOptionSelected = $insuranceOptionSelected;
    }

    /**
     * OrderTime getter.
     *
     * @return \DateTime
     */
    public function getOrderTime()
    {
        return $this->orderTime;
    }

    /**
     * OrderTime setter.
     *
     * @param \DateTime $orderTime
     */
    public function setOrderTime($orderTime)
    {
        $this->orderTime = $orderTime;
    }

    /**
     * PaymentStatus getter.
     *
     * @return PaymentStatus
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * PaymentStatus setter.
     *
     * @param PaymentStatus $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * PaymentType getter.
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * PaymentType setter.
     *
     * @param string $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * PendingReason getter.
     *
     * @return string
     */
    public function getPendingReason()
    {
        return $this->pendingReason;
    }

    /**
     * PendingReason setter.
     *
     * @param string $pendingReason
     */
    public function setPendingReason($pendingReason)
    {
        $this->pendingReason = $pendingReason;
    }

    /**
     * ProtectionEligibility getter.
     *
     * @return string
     */
    public function getProtectionEligibility()
    {
        return $this->protectionEligibility;
    }

    /**
     * ProtectionEligibility setter.
     *
     * @param string $protectionEligibility
     */
    public function setProtectionEligibility($protectionEligibility)
    {
        $this->protectionEligibility = $protectionEligibility;
    }

    /**
     * ProtectionEligibilityType getter.
     *
     * @return string
     */
    public function getProtectionEligibilityType()
    {
        return $this->protectionEligibilityType;
    }

    /**
     * ProtectionEligibilityType setter.
     *
     * @param string $protectionEligibilityType
     */
    public function setProtectionEligibilityType($protectionEligibilityType)
    {
        $this->protectionEligibilityType = $protectionEligibilityType;
    }

    /**
     * ReasonCode getter.
     *
     * @return string
     */
    public function getReasonCode()
    {
        return $this->reasonCode;
    }

    /**
     * ReasonCode setter.
     *
     * @param string $reasonCode
     */
    public function setReasonCode($reasonCode)
    {
        $this->reasonCode = $reasonCode;
    }

    /**
     * SecureMerchantAccountId getter.
     *
     * @return string
     */
    public function getSecureMerchantAccountId()
    {
        return $this->secureMerchantAccountId;
    }

    /**
     * SecureMerchantAccountId setter.
     *
     * @param string $secureMerchantAccountId
     */
    public function setSecureMerchantAccountId($secureMerchantAccountId)
    {
        $this->secureMerchantAccountId = $secureMerchantAccountId;
    }

    /**
     * ShippingOptionIsDefault getter.
     *
     * @return string
     */
    public function getShippingOptionIsDefault()
    {
        return $this->shippingOptionIsDefault;
    }

    /**
     * ShippingOptionIsDefault setter.
     *
     * @param string $shippingOptionIsDefault
     */
    public function setShippingOptionIsDefault($shippingOptionIsDefault)
    {
        $this->shippingOptionIsDefault = $shippingOptionIsDefault;
    }

    /**
     * SuccessPageRedirectRequested getter.
     *
     * @return string
     */
    public function getSuccessPageRedirectRequested()
    {
        return $this->successPageRedirectRequested;
    }

    /**
     * SuccessPageRedirectRequested setter.
     *
     * @param string $successPageRedirectRequested
     */
    public function setSuccessPageRedirectRequested($successPageRedirectRequested)
    {
        $this->successPageRedirectRequested = $successPageRedirectRequested;
    }

    /**
     * TaxAmount getter.
     *
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * TaxAmount setter.
     *
     * @param float $taxAmount
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
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
     * TransactionId getter.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * TransactionId setter.
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * TransactionType getter.
     *
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * TransactionType setter.
     *
     * @param string $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
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
