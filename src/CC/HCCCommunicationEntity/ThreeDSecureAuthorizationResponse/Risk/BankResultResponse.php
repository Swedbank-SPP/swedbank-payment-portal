<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\Risk;

use Jms\Serializer\Annotation;

/**
 * The container for the bank result response.
 *
 * @Annotation\AccessType("public_method")
 */
class BankResultResponse
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
     * Transaction ID.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("transaction_id")
     */
    private $transactionId;

    /**
     * BankResultResponse constructor.
     *
     * @param string $cpiValue
     * @param string $responseCode
     * @param string $responseMessage
     * @param string $transactionId
     */
    public function __construct($cpiValue, $responseCode, $responseMessage, $transactionId)
    {
        $this->cpiValue = $cpiValue;
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
        $this->transactionId = $transactionId;
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

    /**
     * TransactionId getter.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * TransactionId setter.
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
