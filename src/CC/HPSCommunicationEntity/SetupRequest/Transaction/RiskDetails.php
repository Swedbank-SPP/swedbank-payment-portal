<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class RiskDetails
{
    /**
     * Customer’s IP Address.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("ip_address")
     */
    private $ipAddress;

    /**
     * Customer's Email Address.
     *
     * Note: These are generally associated with the individual who is transacting with the merchant.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("email_address")
     */
    private $emailAddress;

    /**
     * RiskDetails constructor.
     *
     * @param string $ipAddress
     * @param string $emailAddress
     */
    public function __construct($ipAddress, $emailAddress)
    {
        $this->ipAddress = $ipAddress;
        $this->emailAddress = $emailAddress;
    }

    /**
     * IpAddress getter.
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * IpAddress setter.
     *
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * EmailAddress getter.
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * EmailAddress setter.
     *
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }
}
