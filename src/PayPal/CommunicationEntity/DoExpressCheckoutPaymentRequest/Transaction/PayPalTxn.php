<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentRequest\Transaction;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress;
use SwedbankPaymentPortal\PayPal\Type\PayPalBool;

/**
 * The container for the pay pal details.
 *
 * @Annotation\AccessType("public_method")
 */
class PayPalTxn
{
    /**
     * Details of the shipping address.
     *
     * @var ShippingAddress
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type(
     *     "SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress"
     * )
     * @Annotation\SerializedName("ShippingAddress")
     */
    private $shippingAddress;

    /**
     * Method to be used.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = 'do_express_checkout_payment';

    /**
     * The 16 digit datacash_ reference, referring to a previous successfully processed transaction.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $reference;

    /**
     * PayPalTxn constructor.
     *
     * @param ShippingAddress $shippingAddress
     * @param string          $reference
     */
    public function __construct(ShippingAddress $shippingAddress, $reference)
    {
        $this->shippingAddress = $shippingAddress;
        $this->reference = $reference;
    }

    /**
     * ShippingAddress getter.
     *
     * @return ShippingAddress
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * ShippingAddress setter.
     *
     * @param ShippingAddress $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Method getter.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method setter.
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Reference getter.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Reference setter.
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
}
