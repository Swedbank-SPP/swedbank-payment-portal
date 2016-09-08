<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest;

use JMS\Serializer\Annotation as Annotation;

/**
 * The container for the XML request. Also contains the version attribute, which we recommend you set to 2.
 *
 * @Annotation\AccessType("public_method")
 */
class HistoricTxn
{
    /**
     * The transaction reference (obtained from the original setup request).
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $reference;

    /**
     * The PaRes as was returned by the issuer ACS.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("pares_message")
     */
    private $paresMessage;

    /**
     * The method or action to be taken by the SwedbankPaymentPortal. “threedsecure_authorization_request” must be used.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = 'threedsecure_authorization_request';

    /**
     * HistoricTxn constructor.
     *
     * @param string $reference
     * @param string $paresMessage
     */
    public function __construct($reference, $paresMessage)
    {
        $this->reference = $reference;
        $this->paresMessage = $paresMessage;
    }

    /**
     * Reference getter.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Reference setter.
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * ParesMessage getter.
     *
     * @return string
     */
    public function getParesMessage()
    {
        return $this->paresMessage;
    }

    /**
     * ParesMessage setter.
     *
     * @param string $paresMessage
     */
    public function setParesMessage($paresMessage)
    {
        $this->paresMessage = $paresMessage;
    }

    /**
     * Method getter.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method setter.
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }
}
