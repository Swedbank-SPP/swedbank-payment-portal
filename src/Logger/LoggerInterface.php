<?php

namespace SwedbankPaymentPortal\Logger;

use SwedbankPaymentPortal\SharedEntity\Type\TransportType;

/**
 * Interface for atm logging.
 */
interface LoggerInterface
{
    /**
     * Function to log data.
     *
     * @param string        $requestXml
     * @param string        $responseXml
     * @param object        $requestObject
     * @param object        $responseObject
     * @param TransportType $type
     */
    public function logData($requestXml, $responseXml, $requestObject, $responseObject, TransportType $type);
}
