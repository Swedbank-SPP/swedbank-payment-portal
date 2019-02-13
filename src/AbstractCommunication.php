<?php

namespace SwedbankPaymentPortal;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryResponse\TransactionQueryResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse\AuthorizationResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\ThreeDSecureAuthorizationResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\CC\Type\AuthorizationStatus;
use SwedbankPaymentPortal\CC\Type\ThreeDAuthorizationStatus;
use SwedbankPaymentPortal\Logger\LoggerInterface;
use SwedbankPaymentPortal\Logger\NullLogger;
use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentResponse\DoExpressCheckoutPaymentResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse\GetExpressCheckoutDetailsResponse;
use SwedbankPaymentPortal\SharedEntity\AbstractResponse;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;
use SwedbankPaymentPortal\SharedEntity\Type\TransportType;

/**
 * Handles communication with guzzle.
 */
class AbstractCommunication
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var CommunicationOptions
     */
    protected $options;

    /**
     * @var Network
     */
    protected $network;

    /**
     * @var SensitiveDataCleanup
     */
    protected $dataCleanup;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Communication constructor.
     *
     * @param Serializer           $serializer
     * @param Network              $network
     * @param SensitiveDataCleanup $sensitiveDataCleanup
     */
    public function __construct(Serializer $serializer, Network $network, SensitiveDataCleanup $sensitiveDataCleanup)
    {
        $this->serializer = $serializer;
        $this->network = $network;
        $this->dataCleanup = $sensitiveDataCleanup;
        $this->logger = new NullLogger();
    }

    /**
     * Options setter.
     *
     * @param CommunicationOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Sets logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Sends specified data to network and logs everything.
     *
     * @param object        $request
     * @param string        $responseClass
     * @param string        $endpoint
     * @param TransportType $type
     * @param boolen $returnArray
     *
     * @return AbstractResponse
     */
    protected function sendDataToNetwork($request, $responseClass, $endpoint, TransportType $type, $returnArray = false)
    {        
        $requestXml = $this->serializer->getXml($request);
        
        $responseObject = $this->network->sendRequest($endpoint, $requestXml);
        
        if ($responseObject->getStatusCode() !== 200) {
            throw new \RuntimeException('Got not 200 response.(status code: ' . $responseObject->getStatusCode() . ')');
        }

        $rawResponse = (string)$responseObject->getBody();
        
        if($returnArray){
            $xml = simplexml_load_string( $rawResponse , null , LIBXML_NOCDATA ); 
            $json = json_encode($xml);
            $this->logger->logData(
                $this->dataCleanup->cleanUpRequestXml($requestXml),
                $rawResponse,
                $this->dataCleanup->cleanUpRequest($request),
                null,
                $type
            );
            return json_decode($json,TRUE);
        } else {
            $response = $this->serializer->getObject($rawResponse, $responseClass);
        }
        
        $this->logger->logData(
            $this->dataCleanup->cleanUpRequestXml($requestXml),
            $rawResponse,
            $this->dataCleanup->cleanUpRequest($request),
            $response,
            $type
        );

        switch (true) {
            case ($response instanceof TransactionQueryResponse):
                if (!in_array($response->getStatus(), [ResponseStatus::accepted(), ResponseStatus::redirect(), ResponseStatus::cancelled(), ResponseStatus::pending()])) {
                    throw new \RuntimeException(
                        'Request error: ' . $response->getReason() . '(status code: ' . $response->getStatus()->id() . ')'
                    );
                }
                break;
            case $response instanceof HPSQueryResponse:
                break;
            default:
                if (!$response->getStatus()->isSuccessful()) {

                    // * do not throw any error exceptions on AuthorizationResponse
                    $skipIf = ($response instanceof AuthorizationResponse);

                    // * do not throw on PayPal communication
                    $skipIf = $skipIf || ($response instanceof GetExpressCheckoutDetailsResponse) || ($response instanceof DoExpressCheckoutPaymentResponse);

                    $skipIf = $skipIf || ($response instanceof ThreeDSecureAuthorizationResponse &&
                            (
                                $response->getStatus() == ThreeDAuthorizationStatus::secureAuthenticationRequired() ||
                                $response->getStatus() == ThreeDAuthorizationStatus::auth3DSTransactionCannotBeAuthorized() ||
                                $response->getStatus() == ThreeDAuthorizationStatus::payerFailed3DSVerification() ||
                                $response->getStatus() == ThreeDAuthorizationStatus::auth3DSTransactionCannotBeAuthorized() ||
                                $response->getStatus() == ThreeDAuthorizationStatus::unableToAuthenticate()
                            )
                        );

                    if (!$skipIf) {
                        throw new \RuntimeException(
                            'Request error: ' . $response->getReason() . '(status code: ' . $response->getStatus()->id() . ')'
                        );
                    }
                }

        }

        return $response;
    }

    /**
     * Options getter.
     *
     * @return CommunicationOptions
     *
     * @throws \InvalidArgumentException
     */
    public function getOptions()
    {
        if (!$this->options) {
            throw new \InvalidArgumentException('Communication options not set.');
        }

        return $this->options;
    }
}
