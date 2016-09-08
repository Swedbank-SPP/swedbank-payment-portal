<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\BillingDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\PersonalDetails;
use Jms\Serializer\Annotation;

/**
 * Class for Swedbank transaction details.
 *
 * @Annotation\AccessType("public_method")
 */
class TransactionDetails
{
    /**
     * The Description which will be presented in Customer bank’s account statement.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("Description")
     * @Annotation\Type("string")
     */
    private $description;

    /**
     * The URL that the merchant’s consumer will be redirected to after a successful transaction.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("SuccessURL")
     * @Annotation\Type("string")
     */
    private $successURL;

    /**
     * The URL that the merchant’s consumer will be redirected to after an unsuccessful transaction.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("FailureURL")
     * @Annotation\Type("string")
     */
    private $failureURL;

    /**
     * The language in which the consumer’s experience will take place.
     * If no language is supplied, the value defaults to English.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("Language")
     * @Annotation\Type("string")
     */
    private $language;

    /**
     * Consumer personal details.
     *
     * @var PersonalDetails
     * @Annotation\SerializedName("PersonalDetails")
     * @Annotation\Type(
     * "SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\PersonalDetails"
     * )
     */
    private $personalDetails;

    /**
     * Billing details.
     *
     * @var BillingDetails
     * @Annotation\SerializedName("BillingDetails")
     * @Annotation\Type(
     * "SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\BillingDetails"
     * )
     */
    private $billingDetails;

    /**
     * TransactionDetails constructor.
     *
     * @param string          $description
     * @param string          $successURL
     * @param string          $failureURL
     * @param string          $language
     * @param PersonalDetails $personalDetails
     * @param BillingDetails  $billingDetails
     */
    public function __construct(
        $description,
        $successURL,
        $failureURL,
        $language,
        PersonalDetails $personalDetails,
        BillingDetails $billingDetails
    ) {
        $this->setDescription($description);
        $this->successURL = $successURL;
        $this->failureURL = $failureURL;
        $this->language = $language;
        $this->personalDetails = $personalDetails;
        $this->billingDetails = $billingDetails;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * SuccessURL getter.
     *
     * @return string
     */
    public function getSuccessURL()
    {
        return $this->successURL;
    }

    /**
     * SuccessURL setter.
     *
     * @param string $successURL
     */
    public function setSuccessURL($successURL)
    {
        $this->successURL = $successURL;
    }

    /**
     * FailureURL getter.
     *
     * @return string
     */
    public function getFailureURL()
    {
        return $this->failureURL;
    }

    /**
     * FailureURL setter.
     *
     * @param string $failureURL
     */
    public function setFailureURL($failureURL)
    {
        $this->failureURL = $failureURL;
    }

    /**
     * Language getter.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Language setter.
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
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
     * BillingDetails getter.
     *
     * @return BillingDetails
     */
    public function getBillingDetails()
    {
        return $this->billingDetails;
    }

    /**
     * BillingDetails setter.
     *
     * @param BillingDetails $billingDetails
     */
    public function setBillingDetails($billingDetails)
    {
        $this->billingDetails = $billingDetails;
    }
}
