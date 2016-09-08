<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class CustomerDetails
{
    /**
     * The container for order details.
     *
     * @var OrderDetails
     *
     * @Annotation\SerializedName("OrderDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\OrderDetails")
     */
    private $orderDetails;

    /**
     * The container for personal details.
     *
     * @var PersonalDetails
     *
     * @Annotation\SerializedName("PersonalDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\PersonalDetails")
     */
    private $personalDetails;

    /**
     * The container for shipping details.
     *
     * @var ShippingDetails
     *
     * @Annotation\SerializedName("ShippingDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\ShippingDetails")
     */
    private $shippingDetails;

    /**
     * The container for payment details.
     *
     * @var PaymentDetails
     *
     * @Annotation\SerializedName("PaymentDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\PaymentDetails")
     */
    private $paymentDetails;

    /**
     * Risk details container.
     *
     * @var RiskDetails
     *
     * @Annotation\SerializedName("RiskDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\RiskDetails")
     */
    private $riskDetails;

    /**
     * CustomerDetails constructor.
     *
     * @param BillingDetails  $billingDetails
     * @param PersonalDetails $personalDetails
     * @param ShippingDetails $shippingDetails
     * @param RiskDetails     $riskDetails
     */
    public function __construct(
        BillingDetails $billingDetails,
        PersonalDetails $personalDetails,
        ShippingDetails $shippingDetails,
        RiskDetails $riskDetails
    ) {
        $this->orderDetails = new OrderDetails($billingDetails);
        $this->personalDetails = $personalDetails;
        $this->shippingDetails = $shippingDetails;
        $this->paymentDetails = new PaymentDetails();
        $this->riskDetails = $riskDetails;
    }

    /**
     * OrderDetails getter.
     *
     * @return OrderDetails
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    /**
     * OrderDetails setter.
     *
     * @param OrderDetails $orderDetails
     */
    public function setOrderDetails($orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    /**
     * PersonalDetails getter.
     *
     * @return PersonalDetails
     */
    public function getPersonalDetails()
    {
        return $this->personalDetails;
    }

    /**
     * PersonalDetails setter.
     *
     * @param PersonalDetails $personalDetails
     */
    public function setPersonalDetails($personalDetails)
    {
        $this->personalDetails = $personalDetails;
    }

    /**
     * ShippingDetails getter.
     *
     * @return ShippingDetails
     */
    public function getShippingDetails()
    {
        return $this->shippingDetails;
    }

    /**
     * ShippingDetails setter.
     *
     * @param ShippingDetails $shippingDetails
     */
    public function setShippingDetails($shippingDetails)
    {
        $this->shippingDetails = $shippingDetails;
    }

    /**
     * PaymentDetails getter.
     *
     * @return PaymentDetails
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * PaymentDetails setter.
     *
     * @param PaymentDetails $paymentDetails
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * RiskDetails getter.
     *
     * @return RiskDetails
     */
    public function getRiskDetails()
    {
        return $this->riskDetails;
    }

    /**
     * RiskDetails setter.
     *
     * @param RiskDetails $riskDetails
     */
    public function setRiskDetails($riskDetails)
    {
        $this->riskDetails = $riskDetails;
    }
}
