<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails;

use Jms\Serializer\Annotation;

/**
 * Class for billing details.
 *
 * @Annotation\AccessType("public_method")
 */
class BillingDetails
{
    /**
     * @var BillingDetails\AmountDetails
     *
     * @Annotation\SerializedName("AmountDetails")
     * @Annotation\Type(
     * "SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\BillingDetails\AmountDetails"
     * )
     */
    private $amountDetails;

    /**
     * BillingDetails constructor.
     *
     * @param BillingDetails\AmountDetails $amountDetails
     */
    public function __construct(BillingDetails\AmountDetails $amountDetails)
    {
        $this->amountDetails = $amountDetails;
    }

    /**
     * AmountDetails getter.
     *
     * @return BillingDetails\AmountDetails
     */
    public function getAmountDetails()
    {
        return $this->amountDetails;
    }

    /**
     * AmountDetails setter.
     *
     * @param BillingDetails\AmountDetails $amountDetails
     */
    public function setAmountDetails($amountDetails)
    {
        $this->amountDetails = $amountDetails;
    }
}
