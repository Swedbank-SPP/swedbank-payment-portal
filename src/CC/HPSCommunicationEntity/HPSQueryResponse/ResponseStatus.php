<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractStatus;

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
    ];

    final public static function accepted() { return self::get(1); }
    final public static function SocketWriteError() { return self::get(2); }
    final public static function Timeout() { return self::get(3); }
    final public static function EditError() { return self::get(5); }
    final public static function CommsError() { return self::get(6); }
    final public static function NotAuthorised() { return self::get(7); }
    final public static function CurrencyError() { return self::get(9); }
    final public static function AuthenticationError() { return self::get(10); }
    final public static function CannotFulfilTransaction() { return self::get(19); }
    final public static function DuplicateTransactionReference() { return self::get(20); }
    final public static function InvalidCardType() { return self::get(21); }
    final public static function InvalidReference() { return self::get(22); }
    final public static function ExpiryDateInvalid() { return self::get(23); }
    final public static function CardHasAlreadyExpired() { return self::get(24); }
    final public static function CardNumberInvalid() { return self::get(25); }

    final public static function VEResErrorResponseReceived() { return self::get(196); }
    final public static function ThreeDSPayerFailedVerification() { return self::get(179); } // ??

    final public static function HpsInappropriateDataSupplied() { return self::get(810); }
    final public static function HpsMissingData() { return self::get(811); }
    final public static function HpsInvalidReference() { return self::get(812); }
    final public static function HpsCommunicationsError() { return self::get(813); }
    final public static function HpsInvalidHpsResponse() { return self::get(814); }
    final public static function HpsInvalidPaymentReference() { return self::get(815); }
    final public static function HpsMerchantNotConfigured() { return self::get(816); }
    final public static function HpsCaptureFieldDataTooLong() { return self::get(817); }
    final public static function HpsDynamicDataFieldTooLong() { return self::get(818); }
    final public static function HpsAwaitingCustomerCard() { return self::get(820); }

    
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
