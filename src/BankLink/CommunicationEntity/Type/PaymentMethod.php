<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;

/**
 * A two digit short code that indicates which Banklink is to be used.
 *
 */
class PaymentMethod extends AbstractEnumerableType
{
    /**
     * Swedbank.
     *
     * @return PaymentMethod
     */
    final public static function swedbank()
    {
        return self::get('SW');
    }

    /**
     * SVENSKA HANDELSBANKEN AB (SWEDEN)
     *
     * @return PaymentMethod
     */
    final public static function svenska()
    {
        return self::get('SH');
    }

    /**
     * Nordea.
     *
     * @return PaymentMethod
     */
    final public static function nordea()
    {
        return self::get('ND');
    }

    /**
     * SEB.
     *
     * @return PaymentMethod
     */
    final public static function seb()
    {
        return self::get('SE');
    }

    /**
     * DNB.
     *
     * @return PaymentMethod
     */
    final public static function dnb()
    {
        return self::get('DN');
    }

    /**
     * Danske.
     *
     * @return PaymentMethod
     */
    final public static function danske()
    {
        return self::get('DL');
    }
    
    /**
     * Citadele.
     *
     * @return PaymentMethod
     */
    final public static function citadele()
    {
        return self::get('CA');
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
     *
     * @return string
     */
    public function serialize(XmlSerializationVisitor $visitor)
    {
        return new \DOMText($this->id());
    }
}
