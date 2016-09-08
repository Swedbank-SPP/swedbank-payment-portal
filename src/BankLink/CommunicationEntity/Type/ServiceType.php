<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractEnumerableType;

/**
 * Value to distinguish between the different Swedbank Banklink Products for each region. Applies to Swedbank only.
 */
class ServiceType extends AbstractEnumerableType
{
    /**
     * Undefined service type.
     *
     * @return ServiceType
     */
    final public static function undefined()
    {
        return self::get('');
    }

    // --------------- SWEDBANK ------------------

    /**
     * Swedbank Estonia.
     *
     * @return ServiceType
     */
    final public static function estBank()
    {
        return self::get('EST_BANK');
    }

    /**
     * Swedbank Lithuania.
     *
     * @return ServiceType
     */
    final public static function litBank()
    {
        return self::get('LIT_BANK');
    }

    /**
     * Swedbank Latvia.
     *
     * @return ServiceType
     */
    final public static function ltvBank()
    {
        return self::get('LTV_BANK');
    }


    /**
     * Swedbank Sweden.
     *
     * @return ServiceType
     */
    final public static function swdBank()
    {
        return self::get('SWD_BANK');
    }

    // ------------------------- SEB --------------------------

    /**
     * SKANDINAVISKA ENSKILDA BANKEN AB (SWEDEN)
     *
     * @return ServiceType
     */
    final public static function sebSwd()
    {
        return self::get('SEB_SWD');
    }

    /**
     * SEB AS banka (LATVIA)
     *
     * @return ServiceType
     */
    final public static function SebLtv()
    {
        return self::get('SEB_LTV');
    }

    /**
     * SEB AB bankas (LITHUANIA)
     *
     * @return ServiceType
     */
    final public static function sebLit()
    {
        return self::get('SEB_LIT');
    }

    /**
     * SEB AS Pank (ESTONIA)
     *
     * @return ServiceType
     */
    final public static function sebEst()
    {
        return self::get('SEB_EST');
    }


    // ------------------------- NORDEA --------------------------

    /**
     * NORDEA BANK AB (SWEDEN)
     *
     * @return ServiceType
     */
    final public static function nrdSwd()
    {
        return self::get('NRD_SWD');
    }

    /**
     * Nordea Bank AB Estonia Branch (ESTONIA)
     *
     * @return ServiceType
     */
    final public static function nrdEst()
    {
        return self::get('NRD_EST');
    }

    /**
     * NORDEA BANK AB LITHUANIA BRANCH (LITHUANIA)
     *
     * @return ServiceType
     */
    final public static function nrdLit()
    {
        return self::get('NRD_LIT');
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
