<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSCancelRequest;

use SwedbankPaymentPortal\SharedEntity\HPSCancelRequest\HPSCancelRequest as ParentHpsCancelRequest;
use JMS\Serializer\Annotation;

/**
 * Class HPSCancelRequest.
 *
 * @Annotation\XmlRoot("Request")
 * @Annotation\AccessType("public_method")
 */
class HPSCancelRequest extends ParentHpsCancelRequest
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
