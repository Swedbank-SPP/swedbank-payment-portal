<?php

namespace SwedbankPaymentPortal\SharedEntity\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

/**
 * Response statuses.
 */
class ResponseStatus extends AbstractStatus
{
    /**
     * Maps string value to integer.
     *
     * @const int[]
     */
    const TYPE_MAP = [
        'AUTHORISED' => 1,
        'PENDING' => 2051,
        'ERROR' => 2052,
        'REDIRECT' => 2053,
        'CANCELLED' => 2054,
        'REQUIRES INVESTIGATION' => 2066,
        'REFUSED' => 7,
    ];

    /**
     * Successful purchase setup.
     *
     * @return ResponseStatus
     */
    final public static function accepted()
    {
        return self::get(1);
    }

    /**
     * Transaction pending.
     *
     * @return ResponseStatus
     */
    final public static function pending()
    {
        return self::get(2051);
    }

    /**
     * DA processing error occurred.
     *
     * @return ResponseStatus
     */
    final public static function error()
    {
        return self::get(2052);
    }

    /**
     * Redirect consumer to APM Provider.
     *
     * @return ResponseStatus
     */
    final public static function redirect()
    {
        return self::get(2053);
    }

    /**
     * Transaction was cancelled.
     *
     * @return ResponseStatus
     */
    final public static function cancelled()
    {
        return self::get(2054);
    }

    /**
     * Transaction requires investigation.
     *
     * @return ResponseStatus
     */
    final public static function requiresInvestigation()
    {
        return self::get(2066);
    }

    /**
     * Transaction was declined by APM provider.
     *
     * @return ResponseStatus
     */
    final public static function refused()
    {
        return self::get(7);
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
        if (array_key_exists((string)$data, self::TYPE_MAP)) {
            $this->assignId(self::TYPE_MAP[(string)$data]);
        } else {
            $this->assignId((int)$data);
        }
    }

    /**
     * Custom serialization logic.
     *
     * @Annotation\HandlerCallback("xml", direction = "serialization")
     *
     * @param XmlSerializationVisitor $visitor
     * @param null|array              $data
     * @param SerializationContext    $context
     *
     * @return \DOMText
     */
    public function serialize(XmlSerializationVisitor $visitor, $data, SerializationContext $context)
    {
        /** @var PropertyMetadata $propertyMetadata */
        $propertyMetadata = iterator_to_array($context->getMetadataStack())[$context->getMetadataStack()->count() - 2];
        if (in_array('asString', $propertyMetadata->type['params'])) {
            return new \DOMText(array_search($this->id(), self::TYPE_MAP));
        }

        return new \DOMText($this->id());
    }
}
