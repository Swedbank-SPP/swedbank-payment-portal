<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\Transaction;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\PayPal\Type\PayPalBool;

/**
 * The container for the pay pal details.
 *
 * @Annotation\AccessType("public_method")
 */
class PayPalTxn
{
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
     * Method to be used.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = 'get_express_checkout_details';

    /**
     * PayPalTxn constructor.
     *
     * @param string $reference
     */
    public function __construct($reference)
    {
        $this->reference = $reference;
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
}
