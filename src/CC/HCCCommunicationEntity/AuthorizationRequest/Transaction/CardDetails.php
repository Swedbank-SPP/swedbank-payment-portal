<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;

use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use Jms\Serializer\Annotation;

/**
 * The 16 digit Payment Gateway reference that is returned from the setup request.
 *
 * The reference is used by the Payment Gateway to lookup the card details and insert them into the authorization
 * request to the acquirer.
 *
 * @Annotation\AccessType("public_method")
 */
class CardDetails
{
    /**
     * The attribute type=”from_hps” must be included on the card details container.
     *
     * @var string
     */
    const TYPE = 'from_hps';

    /**
     * The 16 digit Payment Gateway reference that is returned from the setup request.
     *
     * The reference is used by the Payment Gateway to lookup the card details and insert them into the
     * authorization request to the acquirer.
     *
     * @var string
     */
    private $cardDetailsString;

    /**
     * CardDetails constructor.
     *
     * @param string $cardDetailsString
     */
    public function __construct($cardDetailsString)
    {
        $this->cardDetailsString = $cardDetailsString;
    }

    /**
     * CardDetailsString getter.
     *
     * @return string
     */
    public function getCardDetailsString()
    {
        return $this->cardDetailsString;
    }

    /**
     * CardDetailsString setter.
     *
     * @param string $cardDetailsString
     */
    public function setCardDetailsString($cardDetailsString)
    {
        $this->cardDetailsString = $cardDetailsString;
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
        $this->cardDetailsString = (string)$data;
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
        /** @var \DOMElement $node */
        $node = $visitor->getCurrentNode();
        $node->nodeValue = $this->cardDetailsString;
        $node->setAttribute('type', self::TYPE);
    }
}
