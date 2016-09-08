<?php

namespace SwedbankPaymentPortal\CC\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;

/**
 * Indicates whether the cardholder was registered for 3-D Secure and the PARes / VERes status.
 */
class CardholderRegisterStatus extends AbstractEnumerableType
{
    /**
     * Enrolled.
     *
     * @return CardholderRegisterStatus
     */
    final public static function enrolled()
    {
        return self::get('yes');
    }

    /**
     * Not enrolled.
     *
     * @return CardholderRegisterStatus
     */
    final public static function notEnrolled()
    {
        return self::get('no');
    }

    /**
     * Enrolled, PARes status ‘A’.
     *
     * @return CardholderRegisterStatus
     */
    final public static function attempted()
    {
        return self::get('attempted');
    }

    /**
     * Enrolled, VERes status ‘U’.
     *
     * @return CardholderRegisterStatus
     */
    final public static function chEnrolled()
    {
        return self::get('ch_enrolled_u');
    }

    /**
     * Enrolled, PARes status ‘U’.
     *
     * @return CardholderRegisterStatus
     */
    final public static function txStatusU()
    {
        return self::get('tx_status_u');
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
