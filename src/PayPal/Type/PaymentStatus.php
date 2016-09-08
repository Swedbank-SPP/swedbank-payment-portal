<?php

namespace SwedbankPaymentPortal\PayPal\Type;

use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;
use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

/**
 * Final payment status for PayPal.
 */
class PaymentStatus extends AbstractEnumerableType
{
    /**
     * Completed.
     *
     * @return PaymentStatus
     */
    final public static function completed()
    {
        return self::get('Completed');
    }

    /**
     * Pending.
     *
     * @return PaymentStatus
     */
    final public static function pending()
    {
        return self::get('Pending');
    }

    /**
     * Custom deserialization logic.
     *
     * @Annotation\HandlerCallback("xml", direction = "deserialization")
     *
     * @param XmlDeserializationVisitor $visitor
     * @param null|array                $data
     * @param Context                   $context
     */
    public function deserialize(XmlDeserializationVisitor $visitor, $data, Context $context)
    {
        $this->assignId((string)$data);
    }

    /**
     * Custom serialization logic.
     *
     * @Annotation\HandlerCallback("xml", direction = "serialization")
     *
     * @param XmlSerializationVisitor $visitor
     */
    public function serialize(XmlSerializationVisitor $visitor)
    {
        $visitor->getCurrentNode()->nodeValue = $this->id();
    }
}
