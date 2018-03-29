<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\QueryRequest;

use SwedbankPaymentPortal\SharedEntity\QueryRequest\QueryRequest as ParentQueryRequest;
use JMS\Serializer\Annotation;

/**
 * Class QueryRequest.
 *
 * @Annotation\XmlRoot("Request")
 * @Annotation\AccessType("public_method")
 */
class QueryRequest extends ParentQueryRequest
{
    /**
     * API version used.
     */
    const API_VERSION = 2;

    /**
     * API version used.
     *
     * @var int
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("integer")
     * @Annotation\AccessType("reflection")
     */
    private $version = self::API_VERSION;
}
