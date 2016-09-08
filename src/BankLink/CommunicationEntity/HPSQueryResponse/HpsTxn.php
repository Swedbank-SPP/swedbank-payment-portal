<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse;

use JMS\Serializer\Annotation;

/**
 * The container for the XML response.
 *
 * @Annotation\AccessType("public_method")
 */
class HpsTxn
{
    /**
     * The gateway URL to which the customer is to be redirected.
     *
     * @var AuthAttempt[]
     *
     * @Annotation\Type("array<SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\AuthAttempt>")
     * @Annotation\SerializedName("AuthAttempts")
     * @Annotation\XmlList(entry = "Attempt")
     */
    private $authAttempts;

    /**
     * HpsTxn constructor.
     *
     * @param AuthAttempt[] $authAttempts
     */
    public function __construct(array $authAttempts)
    {
        $this->authAttempts = $authAttempts;
    }

    /**
     * AuthAttempts getter.
     *
     * @return AuthAttempt[]
     */
    public function getAuthAttempts()
    {
        return $this->authAttempts;
    }

    /**
     * AuthAttempts setter.
     *
     * @param AuthAttempt[] $authAttempts
     */
    public function setAuthAttempts(array $authAttempts)
    {
        $this->authAttempts = $authAttempts;
    }
}
