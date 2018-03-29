<?php

namespace SwedbankPaymentPortal\CC\HPSService;

use SwedbankPaymentPortal\AbstractCommunication;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\HCCQueryResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryRequest\HPSQueryRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSCancelRequest\HPSCancelRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSRefundRequest\HPSRefundRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\QueryRequest\QueryRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupResponse\SetupResponse;
use SwedbankPaymentPortal\SharedEntity\Type\TransportType;

/**
 * Handles communication with guzzle.
 */
class Communication extends AbstractCommunication
{
    /**
     * Send a setup request.
     *
     * @param SetupRequest $setupRequest
     *
     * @return SetupResponse
     */
    public function sendSetupRequest(SetupRequest $setupRequest)
    {
        return $this->sendDataToNetwork(
            $setupRequest,
            SetupResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::setup()
        );
    }

    /**
     * Sends a hps query request.
     *
     * @param HPSQueryRequest $hpsQueryRequest
     *
     * @return HPSQueryResponse
     */
    public function sendHPSQueryRequest(HPSQueryRequest $hpsQueryRequest)
    {
        return $this->sendDataToNetwork(
            $hpsQueryRequest,
            HPSQueryResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::hpsQuery()
        );
    }
    
    /**
     * Sends a cancel query request.
     *
     * @param HPSCancelRequest $hpsCancelRequest
     *
     * @return HPSQueryResponse
     */
    public function sendHPSCancelRequest(HPSCancelRequest $hpsCancelRequest)
    {

        return $this->sendDataToNetwork(
            $hpsCancelRequest,
            null,
            $this->getOptions()->getEndpoint(),
            TransportType::hpsCancel(),
            true
        );
    }
    
    /**
     * Sends a refund query request.
     *
     * @param HPSRefundRequest $hpsRefundRequest
     *
     * @return array of Response
     */
    public function sendHPSRefundRequest(HPSRefundRequest $hpsRefundRequest)
    {

        return $this->sendDataToNetwork(
            $hpsRefundRequest,
            null,
            $this->getOptions()->getEndpoint(),
            TransportType::hpsRefund(),
            true
        );
    }
    
        /**
     * Sends a query request.
     *
     * @param QueryRequest $queryRequest
     *
     * @return QueryResponse
     */
    public function sendQueryRequest(QueryRequest $queryRequest)
    {

        return $this->sendDataToNetwork(
            $queryRequest,
            null,
            $this->getOptions()->getEndpoint(),
            TransportType::hpsQuery(),
            true
        );
    }

    /**
     * Send query attempt request
     *
     * @param HPSQueryRequest $hpsQueryRequest
     * @return HCCQueryResponse
     */
    public function sendQueryAttemptRequest(HPSQueryRequest $hpsQueryRequest)
    {
        return $this->sendDataToNetwork(
            $hpsQueryRequest,
            HCCQueryResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::hccQueryRequest()
        );
    }

}
