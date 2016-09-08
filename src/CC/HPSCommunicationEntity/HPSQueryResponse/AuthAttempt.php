<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\RiskResponse\RiskResponse;

/**
 * Provides details of the payment attempt.
 *
 * @Annotation\AccessType("public_method")
 */
class AuthAttempt
{
    /**
     * Risk response container.
     *
     * @var RiskResponse
     *
     * @Annotation\SerializedName("RiskResponse")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\RiskResponse\RiskResponse")
     * @Annotation\XmlElement(cdata=false)
     */
    private $riskResponse;

    /**
     * The payment provider’s reference for the authorisation attempt.
     * This field is only present is the payment attempt was successful.
     *
     * @var string
     *
     * @Annotation\SerializedName("datacash_reference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $dataCashReference;

    /**
     * The status code for the result of the attempt.
     *
     * @var ResponseStatus
     *
     * @Annotation\SerializedName("dc_response")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\ResponseStatus")
     * @Annotation\XmlElement(cdata=false)
     */
    private $dcResponse;

    /**
     * The reason for the attempt.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $reason;

    /**
     * AuthAttempt constructor.
     *
     * @param RiskResponse   $riskResponse
     * @param string         $dataCashReference
     * @param ResponseStatus $dcResponse
     * @param string         $reason
     */
    public function __construct(RiskResponse $riskResponse, $dataCashReference, ResponseStatus $dcResponse, $reason)
    {
        $this->riskResponse = $riskResponse;
        $this->dataCashReference = $dataCashReference;
        $this->dcResponse = $dcResponse;
        $this->reason = $reason;
    }

    /**
     * RiskResponse getter.
     *
     * @return RiskResponse
     */
    public function getRiskResponse()
    {
        return $this->riskResponse;
    }

    /**
     * RiskResponse setter.
     *
     * @param RiskResponse $riskResponse
     */
    public function setRiskResponse($riskResponse)
    {
        $this->riskResponse = $riskResponse;
    }

    /**
     * DataCashReference getter.
     *
     * @return string
     */
    public function getDataCashReference()
    {
        return $this->dataCashReference;
    }

    /**
     * DataCashReference setter.
     *
     * @param string $dataCashReference
     */
    public function setDataCashReference($dataCashReference)
    {
        $this->dataCashReference = $dataCashReference;
    }

    /**
     * DcResponse getter.
     *
     * @return ResponseStatus
     */
    public function getDcResponse()
    {
        return $this->dcResponse;
    }

    /**
     * DcResponse setter.
     *
     * @param ResponseStatus $dcResponse
     */
    public function setDcResponse($dcResponse)
    {
        $this->dcResponse = $dcResponse;
    }

    /**
     * Reason getter.
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Reason setter.
     *
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }
}
