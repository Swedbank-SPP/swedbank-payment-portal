<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSRefundRequest;

use SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\HPSRefundRequest as ParentHpsRefundRequest;
use JMS\Serializer\Annotation;

/**
 * Class HPSRefundRequest.
 *
 * @Annotation\XmlRoot("Request")
 * @Annotation\AccessType("public_method")
 */
class HPSRefundRequest extends ParentHpsRefundRequest
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
