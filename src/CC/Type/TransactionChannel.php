<?php

namespace SwedbankPaymentPortal\CC\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;

/**
 * This reflects the manner in which the customer transaction has been captured.
 *
 * This will be used to distinguish the ‘ticketless’ on-line purchaser, from Moto taken orders directly
 * by a booking system.
 */
class TransactionChannel extends AbstractEnumerableType
{
    /**
     * Physical.
     *
     * @return TransactionChannel
     */
    final public static function physical()
    {
        return self::get('P');
    }

    /**
     * Moto.
     *
     * @return TransactionChannel
     */
    final public static function moto()
    {
        return self::get('M');
    }

    /**
     * Web.
     *
     * @return TransactionChannel
     */
    final public static function web()
    {
        return self::get('W');
    }

    /**
     * Kiosk.
     *
     * @return TransactionChannel
     */
    final public static function kiosk()
    {
        return self::get('K');
    }

    /**
     * In-Store.
     *
     * @return TransactionChannel
     */
    final public static function inStore()
    {
        return self::get('I');
    }

    /**
     * Mail Order.
     *
     * @return TransactionChannel
     */
    final public static function mailOrder()
    {
        return self::get('S');
    }
    
    /**
     * Other.
     *
     * @return TransactionChannel
     */
    final public static function other()
    {
        return self::get('O');
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
