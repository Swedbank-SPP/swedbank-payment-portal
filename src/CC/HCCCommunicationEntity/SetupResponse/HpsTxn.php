<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupResponse;

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
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\SerializedName("hps_url")
     * @Annotation\XmlElement(cdata=false)
     */
    private $hpsUrl;

    /**
     * The hosted session which is used in conjunction with the URL to redirect the customer.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\SerializedName("session_id")
     * @Annotation\XmlElement(cdata=false)
     */
    private $sessionId;

    /**
     * HpsTXN constructor.
     *
     * @param string $hpsUrl
     * @param string $sessionId
     */
    public function __construct($hpsUrl, $sessionId)
    {
        $this->hpsUrl = $hpsUrl;
        $this->sessionId = $sessionId;
    }

    /**
     * HpsUrl getter.
     *
     * @return string
     */
    public function getHpsUrl()
    {
        return $this->hpsUrl;
    }

    /**
     * HpsUrl setter.
     *
     * @param string $hpsUrl
     */
    public function setHpsUrl($hpsUrl)
    {
        $this->hpsUrl = $hpsUrl;
    }

    /**
     * SessionId getter.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * SessionId setter.
     *
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
