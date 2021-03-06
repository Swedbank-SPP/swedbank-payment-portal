<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryRequest;

use SwedbankPaymentPortal\SharedEntity\HPSQueryRequest\HPSQueryRequest as ParentHpsQueryRequest;
use JMS\Serializer\Annotation;

/**
 * Class HPSQueryRequest.
 *
 * @Annotation\XmlRoot("Request")
 * @Annotation\AccessType("public_method")
 */
class HPSQueryRequest extends ParentHpsQueryRequest
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
