<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\APMTxn;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\PurchaseRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails;
use JMS\Serializer\Annotation;

/**
 * The container for the alternative payment.
 *
 * @Annotation\AccessType("public_method")
 */
class AlternativePayment
{
    /**
     * The version used for the APM’s complex structure.
     *
     * @var string
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("string")
     * @Annotation\AccessType("reflection")
     */
    private $version = PurchaseRequest::API_VERSION;
}
