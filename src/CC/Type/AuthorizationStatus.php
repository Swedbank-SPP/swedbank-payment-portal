<?php

namespace SwedbankPaymentPortal\CC\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractStatus;

/**
 * A numeric status code of authorization response.
 */
class AuthorizationStatus extends AbstractStatus
{

    /**
     * Method will return true if you can process transaction without 3ds authentication after you've got specified
     * authorization status
     *
     * @param AuthorizationStatus $authorizationStatus
     * @return bool
     */
    public static function canBeProcessedWithout3DS(AuthorizationStatus $authorizationStatus)
    {
        return (
            $authorizationStatus == AuthorizationStatus::cardNotEnrolled() ||
            $authorizationStatus == AuthorizationStatus::cardNotEnrolledCache() ||
            $authorizationStatus == AuthorizationStatus::noVEResFromDS() ||
            $authorizationStatus == AuthorizationStatus::invalidVEResFromDS() ||
            $authorizationStatus == AuthorizationStatus::unableToVerify()
        );
    }

    /**
     * Successful authorization setup.
     *
     * @return AuthorizationStatus
     */
    final public static function accepted()
    {
        return self::get(1);
    }

    /**
     * ThreeDSecure Authentication Required.
     *
     * @return AuthorizationStatus
     */
    final public static function secureAuthenticationRequired()
    {
        return self::get(150);
    }

    /**
     * 3DS No VERes from DS
     * @return $this
     */
    final public static function noVEResFromDS()
    {
        return self::get(159);
    }

    /**
     * 3DS Invalid VERes from DS
     *
     * @return AuthorizationStatus
     */
    final public static function invalidVEResFromDS()
    {
        return self::get(160);
    }

    /**
     * Card not enrolled.
     *
     * @return AuthorizationStatus
     */
    final public static function cardNotEnrolled()
    {
        return self::get(162);
    }

    /**
     * Card not enrolled in cache.
     *
     * @return AuthorizationStatus
     */
    final public static function cardNotEnrolledCache()
    {
        return self::get(172);
    }

    /**
     * Invalid VEReq
     * @return $this
     */
    final public static function invalidVEReq()
    {
        return self::get(186);
    }

    /**
     * Unable to Verify
     * @return $this
     */
    final public static function unableToVerify()
    {
        return self::get(187);
    }

    /**
     * Invalid XML.
     *
     * @return AuthorizationStatus
     */
    final public static function invalidXml()
    {
        return self::get(60);
    }


    /**
     * Invalid Payment Reference
     *
     * @return AuthorizationStatus
     */
    final public static function invalidPaymentReference()
    {
        return self::get(815);
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
        $this->assignId((int)$data);
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
