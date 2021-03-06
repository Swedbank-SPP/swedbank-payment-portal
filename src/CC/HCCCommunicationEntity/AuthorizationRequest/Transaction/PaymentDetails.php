<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the payment type details.
 *
 * @Annotation\AccessType("reflection")
 */
class PaymentDetails
{
    /**
     * This is the mechanism with which the client chooses to purchase. Should be populated with CC = Bank Card.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     * @Annotation\SerializedName("payment_method")
     */
    private $paymentMethod = 'CC';
}
