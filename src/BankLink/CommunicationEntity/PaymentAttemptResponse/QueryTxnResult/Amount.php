<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult;

use JMS\Serializer\Annotation;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use JMS\Serializer\Context;

/**
 * The amount debited from the consumer’s account at Swedbank.
 *
 * The field type is a numeric value in cents.
 */
class Amount
{
    /**
     * The transaction amount. This value must be sent as cents.
     *
     * @var int
     *
     * @Annotation\XmlAttribute
     * @Annotation\SerializedName("Amount")
     * @Annotation\Type("integer")
     */
    private $value;

    /**
     * The transaction currency exponent.
     *
     * @var int
     *
     * @Annotation\XmlAttribute
     * @Annotation\SerializedName("Exponent")
     * @Annotation\Type("integer")
     */
    private $exponent;

    /**
     * The transaction currency.
     *
     * @var int
     *
     * @Annotation\XmlAttribute
     * @Annotation\SerializedName("CurrencyCode")
     * @Annotation\Type("integer")
     */
    private $currencyCode;

    /**
     * Amount constructor.
     *
     * @param int $value
     * @param int $exponent
     * @param int $currencyCode
     */
    public function __construct($value, $exponent, $currencyCode)
    {
        $this->value = $value;
        $this->exponent = $exponent;
        $this->currencyCode = $currencyCode;
    }

    /**
     * Value getter.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Value setter.
     *
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Exponent getter.
     *
     * @return int
     */
    public function getExponent()
    {
        return $this->exponent;
    }

    /**
     * Exponent setter.
     *
     * @param int $exponent
     */
    public function setExponent($exponent)
    {
        $this->exponent = $exponent;
    }

    /**
     * CurrencyCode getter.
     *
     * @return int
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * CurrencyCode setter.
     *
     * @param int $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * Custom deserialization logic.
     *
     * @Annotation\HandlerCallback("xml", direction = "deserialization")
     *
     * @param XmlDeserializationVisitor $visitor
     * @param \SimpleXMLElement         $data
     * @param Context                   $context
     */
    public function deserialize(XmlDeserializationVisitor $visitor, $data, Context $context)
    {
        $this->setExponent((int)$this->getAttribute($data->attributes(), 'Exponent'));
        $this->setCurrencyCode((int)$this->getAttribute($data->attributes(), 'CurrencyCode'));
        $this->setValue((int)$data);
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
        $node->setAttribute('CurrencyCode', $this->getCurrencyCode());
        $node->setAttribute('Exponent', $this->getExponent());
        $node->nodeValue = $this->getValue();
    }

    /**
     * Returns attribute.
     *
     * @param \SimpleXMLElement $attributes
     * @param string            $key
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    private function getAttribute($attributes, $key)
    {
        if (!isset($attributes[$key])) {
            throw new \InvalidArgumentException("Attribute {$key} not set.");
        }

        return $attributes[$key];
    }
}
