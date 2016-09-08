<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\BillingDetails;

use Jms\Serializer\Annotation;

/**
 * Class for amount details.
 *
 * @Annotation\AccessType("public_method")
 */
class AmountDetails
{
    /**
     * The transaction amount. This value must be sent as cents.
     *
     * @var int
     *
     * @Annotation\SerializedName("Amount")
     * @Annotation\Type("integer")
     */
    private $amount;

    /**
     * The transaction currency exponent.
     *
     * @var int
     *
     * @Annotation\SerializedName("Exponent")
     * @Annotation\Type("integer")
     */
    private $exponent;

    /**
     * The transaction currency.
     *
     * @var int
     *
     * @Annotation\SerializedName("CurrencyCode")
     * @Annotation\Type("integer")
     */
    private $currencyCode;

    /**
     * AmountDetails constructor.
     *
     * @param int $amount
     * @param int $exponent
     * @param int $currencyCode
     */
    public function __construct($amount, $exponent, $currencyCode)
    {
        $this->amount = $amount;
        $this->exponent = $exponent;
        $this->currencyCode = $currencyCode;
    }

    /**
     * Amount getter.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Amount setter.
     *
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Exponent getter.
     *
     * @return int
     */
    public function getExponent()
    {
        return $this->exponent;
    }

    /**
     * Exponent setter.
     *
     * @param int $exponent
     */
    public function setExponent($exponent)
    {
        $this->exponent = $exponent;
    }

    /**
     * CurrencyCode getter.
     *
     * @return int
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * CurrencyCode setter.
     *
     * @param int $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }
}
