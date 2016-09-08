<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest;

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
}
