<?php

// in autoloader and library needed for HPS payment
include dirname(__FILE__) . '/SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Logger\LoggerInterface;

class Swedbank_Client_Logger implements LoggerInterface
{
    public function __construct()
    {
    }

    public function logData(
        $requestXml,
        $responseXml,
        $requestObject,
        $responseObject,
        \SwedbankPaymentPortal\SharedEntity\Type\TransportType $type
    ) {

        $requestType = $type->id();
        $request = $this->prettyXml($requestXml);
        $response = $responseXml;

		file_put_contents('logfile.log', "\n-----\n$requestType\n$request\n\n$response\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * Method formats given XML into pretty readable format
     *
     * @param $xml
     *
     * @return string
     */
    private function prettyXml($xml)
    {
        $doc = new DomDocument('1.0');
        $doc->loadXML($xml);
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput       = true;

        $prettyXml = $doc->saveXML();

        return $prettyXml;
    }
}