<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction;
use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\PayPal\Type\AddressStatus;

/**
 * The container for the XML response.
 *
 * @Annotation\AccessType("public_method")
 */
class BillingAddress
{
    /**
     * The City / Town associated to the shipping address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $city;

    /**
     * The Country associated to the shipping address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("country_code")
     */
    private $countryCode;

    /**
     * The name of the customer associated to the payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $name;

    /**
     * UK postcode, US ZIP code or other country-specific postal code.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("postcode")
     */
    private $postCode;

    /**
     * The state, province or region.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $region;

    /**
     * The first line of the shipping address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("street_address1")
     */
    private $addressLine1;

    /**
     * The second line of the billing address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("street_address2")
     */
    private $addressLine2;

    /**
     * Phone number.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("telephone_number")
     */
    private $telephoneNumber;

    /**
     * Phone number.
     *
     * @var AddressStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\PayPal\Type\AddressStatus")
     * @Annotation\SerializedName("address_status")
     */
    private $addressStatus;

    /**
     * BillingAddress constructor.
     *
     * @param AddressStatus $addressStatus
     */
    public function __construct(AddressStatus $addressStatus)
    {
        $this->addressStatus = $addressStatus;
    }

    /**
     * City getter.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * City setter.
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * CountryCode getter.
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * CountryCode setter.
     *
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * Name getter.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Name setter.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * PostCode getter.
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * PostCode setter.
     *
     * @param string $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * Region getter.
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Region setter.
     *
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * AddressLine1 getter.
     *
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * AddressLine1 setter.
     *
     * @param string $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * AddressLine2 getter.
     *
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * AddressLine2 setter.
     *
     * @param string $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * TelephoneNumber getter.
     *
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * TelephoneNumber setter.
     *
     * @param string $telephoneNumber
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * AddressStatus getter.
     *
     * @return AddressStatus
     */
    public function getAddressStatus()
    {
        return $this->addressStatus;
    }

    /**
     * AddressStatus setter.
     *
     * @param AddressStatus $addressStatus
     */
    public function setAddressStatus($addressStatus)
    {
        $this->addressStatus = $addressStatus;
    }
}
