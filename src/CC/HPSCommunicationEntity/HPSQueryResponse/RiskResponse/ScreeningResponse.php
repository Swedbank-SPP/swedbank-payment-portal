<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\RiskResponse;

use JMS\Serializer\Annotation;

/**
 * The container for the screening response.
 *
 * @Annotation\AccessType("public_method")
 */
class ScreeningResponse
{
    /**
     * Additional messages.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("cpi_value")
     */
    private $cpiValue;

    /**
     * Response code.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("response_code")
     */
    private $responseCode;

    /**
     * Response message.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("response_message")
     */
    private $responseMessage;

    /**
     * ScreeningResponse constructor.
     *
     * @param string $cpiValue
     * @param string $responseCode
     * @param string $responseMessage
     */
    public function __construct($cpiValue, $responseCode, $responseMessage)
    {
        $this->cpiValue = $cpiValue;
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
    }

    /**
     * CpiValue getter.
     *
     * @return string
     */
    public function getCpiValue()
    {
        return $this->cpiValue;
    }

    /**
     * CpiValue setter.
     *
     * @param string $cpiValue
     */
    public function setCpiValue($cpiValue)
    {
        $this->cpiValue = $cpiValue;
    }

    /**
     * ResponseCode getter.
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * ResponseCode setter.
     *
     * @param string $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

    /**
     * ResponseMessage getter.
     *
     * @return string
     */
    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * ResponseMessage setter.
     *
     * @param string $responseMessage
     */
    public function setResponseMessage($responseMessage)
    {
        $this->responseMessage = $responseMessage;
    }
}
