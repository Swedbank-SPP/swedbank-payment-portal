<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptRequest;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest\HPSQueryRequest;

/**
 * Class PaymentAttemptRequest.
 *
 * @Annotation\XmlRoot("Request")
 */
class PaymentAttemptRequest extends HPSQueryRequest
{
}
