<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use JMS\Serializer\Annotation;

/**
 * The container for the HPS (hosted page) details.
 *
 * @Annotation\AccessType("public_method")
 */
class HPSTxn
{
    /**
     * The Page Set ID which corresponds to the Hosted Page configuration onthe Gateway.
     *
     * @var int
     *
     * @Annotation\Type("integer")
     */
    private $pageSetId = 1;

    /**
     * Indicates the Hosted Method to be used. Value must match = “setup_full”.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = 'setup_full';

    /**
     * A URL to which the customer will be returned when the transaction processing has been completed.
     *
     * A secure (https) URL must be provided. The customer will be returned
     * to this URL only after a successful transaction.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("return_url")
     */
    private $returnUrl;

    /**
     * A URL to which the customer will be returned if the session ID has expired.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("expiry_url")
     */
    private $expiryUrl;

    /**
     * A URL to which the customer will be returned to on error.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("error_url")
     */
    private $errorUrl;

    /**
     * The container for the Dynamic Data that is used to display information on the hosted page.
     *
     * @var DynamicData
     *
     * @Annotation\SerializedName("DynamicData")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\DynamicData")
     */
    private $dynamicData;

    /**
     * HPSTxn constructor.
     *
     * @param string      $expiryUrl
     * @param string      $returnUrl
     * @param string      $errorUrl
     * @param int         $pageSetId
     * @param DynamicData $dynamicData
     */
    public function __construct($expiryUrl, $returnUrl, $errorUrl, $pageSetId = 1, DynamicData $dynamicData = null)
    {
        $this->expiryUrl = $expiryUrl;
        $this->returnUrl = $returnUrl;
        $this->errorUrl = $errorUrl;
        $this->pageSetId = $pageSetId;
        $this->dynamicData = $dynamicData;
    }

    /**
     * PageSetId getter.
     *
     * @return int
     */
    public function getPageSetId()
    {
        return $this->pageSetId;
    }

    /**
     * PageSetId setter.
     *
     * @param int $pageSetId
     */
    public function setPageSetId($pageSetId)
    {
        $this->pageSetId = $pageSetId;
    }

    /**
     * Method getter.
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method setter.
     *
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * ReturnUrl getter.
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * ReturnUrl setter.
     *
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * ExpiryUrl getter.
     *
     * @return string
     */
    public function getExpiryUrl()
    {
        return $this->expiryUrl;
    }

    /**
     * ExpiryUrl setter.
     *
     * @param string $expiryUrl
     */
    public function setExpiryUrl($expiryUrl)
    {
        $this->expiryUrl = $expiryUrl;
    }

    /**
     * DynamicData getter.
     *
     * @return DynamicData
     */
    public function getDynamicData()
    {
        return $this->dynamicData;
    }

    /**
     * DynamicData setter.
     *
     * @param DynamicData $dynamicData
     */
    public function setDynamicData($dynamicData)
    {
        $this->dynamicData = $dynamicData;
    }

    /**
     * ErrorUrl getter.
     *
     * @return string
     */
    public function getErrorUrl()
    {
        return $this->errorUrl;
    }

    /**
     * ErrorUrl setter.
     *
     * @param string $errorUrl
     */
    public function setErrorUrl($errorUrl)
    {
        $this->errorUrl = $errorUrl;
    }
}
