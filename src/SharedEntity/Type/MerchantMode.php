<?php

namespace SwedbankPaymentPortal\SharedEntity\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;

/**
 * Indicates if simulators have been used or a payment provider has been contacted.
 *
 * Live will always be returned. Production and Test(Accreditation) environments are accessed via separate URL’s.
 */
class MerchantMode extends AbstractEnumerableType
{
    /**
     * Not a test.
     *
     * @return MerchantMode
     */
    final public static function live()
    {
        return self::get('LIVE');
    }

    /**
     * Test.
     *
     * @return MerchantMode
     */
    final public static function test()
    {
        return self::get('TEST');
    }

    /**
     * Accreditation.
     *
     * @return MerchantMode
     */
    final public static function accreditation()
    {
        return self::get('ACCREDITATION');
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
