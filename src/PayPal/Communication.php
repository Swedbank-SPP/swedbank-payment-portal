<?php

namespace SwedbankPaymentPortal\PayPal;

use SwedbankPaymentPortal\AbstractCommunication;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentRequest\DoExpressCheckoutPaymentRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentResponse\DoExpressCheckoutPaymentResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\GetExpressCheckoutDetailsRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse\GetExpressCheckoutDetailsResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\SetExpressCheckoutRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse\SetExpressCheckoutResponse;
use SwedbankPaymentPortal\SharedEntity\Type\TransportType;

/**
 * Handles communication with guzzle.
 */
class Communication extends AbstractCommunication
{
    /**
     * Send a setup request.
     *
     * @param SetExpressCheckoutRequest $setupRequest
     *
     * @return SetExpressCheckoutResponse
     */
    public function sendSetupRequest(SetExpressCheckoutRequest $setupRequest)
    {
        return $this->sendDataToNetwork(
            $setupRequest,
            SetExpressCheckoutResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::setup()
        );
    }

    /**
     * Send a details request.
     *
     * @param GetExpressCheckoutDetailsRequest $detailsRequest
     *
     * @return GetExpressCheckoutDetailsResponse
     */
    public function sendGetDetailsRequest(GetExpressCheckoutDetailsRequest $detailsRequest)
    {
        return $this->sendDataToNetwork(
            $detailsRequest,
            GetExpressCheckoutDetailsResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::expressDetailsRequest()
        );
    }

    /**
     * Send a details request.
     *
     * @param DoExpressCheckoutPaymentRequest $checkoutRequest
     *
     * @return DoExpressCheckoutPaymentResponse
     */
    public function sendDoCheckoutRequest(DoExpressCheckoutPaymentRequest $checkoutRequest)
    {
        return $this->sendDataToNetwork(
            $checkoutRequest,
            DoExpressCheckoutPaymentResponse::class,
            $this->getOptions()->getEndpoint(),
            TransportType::expressDetailsRequest()
        );
    }
}
