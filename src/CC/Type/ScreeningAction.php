<?php

namespace SwedbankPaymentPortal\CC\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;

/**
 * This will indicate when the transaction is to be screened pre or post authorisation.
 */
class ScreeningAction extends AbstractEnumerableType
{
    /**
     * Pre-authorization fraud screening request.
     *
     * @return ScreeningAction
     */
    final public static function preAuthorization()
    {
        return self::get('1');
    }

    /**
     * Post-authorization fraud screening request.
     *
     * @return ScreeningAction
     */
    final public static function postAuthorization()
    {
        return self::get('2');
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
