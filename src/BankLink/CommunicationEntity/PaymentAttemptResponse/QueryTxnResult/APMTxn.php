<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult;

use JMS\Serializer\Annotation;

/**
 * The top-level container for the APM specific transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class APMTxn
{
    /**
     * The merchant’s APM account details.
     *
     * @var string
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("string")
     * @Annotation\SerializedName("AccountName")
     */
    private $accountName;

    /**
     * The top-level XML element container for the purchase transaction.
     *
     * @var Purchase
     *
     * @Annotation\SerializedName("Purchase")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Purchase")
     */
    private $purchase;

    /**
     * APMTxn constructor.
     *
     * @param string   $accountName
     * @param Purchase $purchase
     */
    public function __construct($accountName, Purchase $purchase)
    {
        $this->accountName = $accountName;
        $this->purchase = $purchase;
    }

    /**
     * AccountName getter.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * AccountName setter.
     *
     * @param string $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }

    /**
     * Purchase getter.
     *
     * @return Purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * Purchase setter.
     *
     * @param Purchase $purchase
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    }
}
