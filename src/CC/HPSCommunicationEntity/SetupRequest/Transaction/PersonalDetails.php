<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for personal details about the customer.
 *
 * @Annotation\AccessType("public_method")
 */
class PersonalDetails
{
    /**
     * The customer’s date of birth (if known).
     *
     * @var \DateTime
     *
     * @Annotation\Type("DateTime<'Y-m-d'>")
     * @Annotation\SerializedName("date_of_birth")
     * @Annotation\XmlElement(cdata=false)
     */
    private $dateOfBirth;

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
     * The customer’s telephone number.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $telephone;

    /**
     * PersonalDetails constructor.
     *
     * @param string    $firstName
     * @param string    $surname
     * @param string    $telephone
     * @param \DateTime $dateOfBirth
     */
    public function __construct($firstName, $surname, $telephone, \DateTime $dateOfBirth = null)
    {
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->telephone = $telephone;
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * Telephone getter.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Telephone setter.
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
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
     * DateOfBirth getter.
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * DateOfBirth setter.
     *
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }
}
