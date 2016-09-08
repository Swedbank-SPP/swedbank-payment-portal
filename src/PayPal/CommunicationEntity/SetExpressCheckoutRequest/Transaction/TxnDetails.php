<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\Transaction;

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
     * @param Amount $amount
     * @param string $merchantReference
     */
    public function __construct(Amount $amount, $merchantReference)
    {
        $this->amount = $amount;
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
}
