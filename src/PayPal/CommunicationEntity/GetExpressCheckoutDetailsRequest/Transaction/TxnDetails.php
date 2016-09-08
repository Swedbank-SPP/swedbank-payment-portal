<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\Transaction;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\Amount;

/**
 * The container transaction details.
 *
 * @Annotation\AccessType("public_method")
 */
class TxnDetails
{
    /**
     * Merchants can use a value such as an order number or an invoice number
     * as the merchant reference. To allow cardholders to repeat a transaction
     * that was declined and keep the same order number or invoice number, the
     * merchantreference must be modified by appending extra characters for
     * each subsequent attempt.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("merchantreference")
     * @Annotation\Type("string")
     */
    private $merchantReference;

    /**
     * TxnDetails constructor.
     *
     * @param string $merchantReference
     */
    public function __construct($merchantReference)
    {
        $this->merchantReference = $merchantReference;
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
}
