<?php

namespace SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction;

use JMS\Serializer\Annotation;

/**
 * Class HPSRefundRequest.
 *
 * @Annotation\AccessType("public_method")
 */
class TxnDetails
{

    /**
     * Amound
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $amount;

    /**
     * TxnDetails constructor.
     *
     * @param string $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Amount getter.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Amount setter.
     *
     * @param string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
