<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult;

use JMS\Serializer\Annotation;

/**
 * The amount debited from the consumer’s account at Swedbank.
 *
 * The field type is a numeric value in cents.
 */
class RiskResult
{
    /**
     * The risk status code.
     *
     * @var int
     *
     * @Annotation\SerializedName("StatusCode")
     * @Annotation\Type("integer")
     */
    private $statusCode;

    /**
     * The text field that describes the risk status code.
     *
     * @var string
     *
     * @Annotation\SerializedName("StatusDescription")
     * @Annotation\Type("string")
     */
    private $statusDescription;

    /**
     * RiskResult constructor.
     *
     * @param int    $statusCode
     * @param string $statusDescription
     */
    public function __construct($statusCode, $statusDescription)
    {
        $this->statusCode = $statusCode;
        $this->statusDescription = $statusDescription;
    }

    /**
     * StatusCode getter.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * StatusCode setter.
     *
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * StatusDescription getter.
     *
     * @return string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * StatusDescription setter.
     *
     * @param string $statusDescription
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;
    }
}
