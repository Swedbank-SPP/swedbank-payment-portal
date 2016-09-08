<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class ShippingDetails
{
    /**
     * The title of the customer associated to the payment, for example Mr, Mrs or Miss.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $title;

    /**
     * The first name of the customer associated to the payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("first_name")
     */
    private $firstName;

    /**
     * The surname of the customer associated to the payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $surname;

    /**
     * The first line of the shipping address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("address_line1")
     */
    private $addressLine1;

    /**
     * The second line of the billing address
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("address_line2")
     */
    private $addressLine2;

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
     */
    private $country;

    /**
     * The zip code of the shipping adress associated to the payment.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("zip_code")
     */
    private $zipCode;

    /**
     * ShippingDetails constructor.
     *
     * @param string $title
     * @param string $firstName
     * @param string $surname
     * @param string $addressLine1
     * @param string $addressLine2
     * @param string $city
     * @param string $country
     * @param string $zipCode
     */
    public function __construct($title, $firstName, $surname, $addressLine1, $addressLine2, $city, $country, $zipCode)
    {
        $this->title = $title;
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->country = $country;
        $this->zipCode = $zipCode;
    }

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Title setter.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * FirstName getter.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * FirstName setter.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Surname getter.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Surname setter.
     *
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
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
}
