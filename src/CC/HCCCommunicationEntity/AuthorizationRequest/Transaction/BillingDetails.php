<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * Note: Billing Details are optional.
 *
 * @Annotation\AccessType("public_method")
 */
class BillingDetails
{
    /**
     * State province.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("state_province")
     */
    private $stateProvince;

    /**
     * The name of the customer associated to the payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("name")
     */
    private $name;

    /**
     * The zip code of the customer associated to the payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("zip_code")
     */
    private $zipCode;

    /**
     * The first line of the billing address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("address_line1")
     */
    private $addressLine1;

    /**
     * The second line of the billing address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("address_line2")
     */
    private $addressLine2;

    /**
     * The City / Town associated to the billing address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $city;

    /**
     * The Country associated to the billing address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $country;

    /**
     * BillingDetails constructor.
     *
     * @param string $stateProvince
     * @param string $name
     * @param string $zipCode
     * @param string $addressLine1
     * @param string $addressLine2
     * @param string $city
     * @param string $country
     */
    public function __construct($stateProvince, $name, $zipCode, $addressLine1, $addressLine2, $city, $country)
    {
        $this->stateProvince = $stateProvince;
        $this->name = $name;
        $this->zipCode = $zipCode;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->country = $country;
    }

    /**
     * StateProvince getter.
     *
     * @return string
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * StateProvince setter.
     *
     * @param string $stateProvince
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
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
     * ZipCode getter.
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * ZipCode setter.
     *
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
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
     * Country getter.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Country setter.
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
