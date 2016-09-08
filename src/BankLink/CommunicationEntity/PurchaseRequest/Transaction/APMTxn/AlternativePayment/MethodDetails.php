<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment;

use DOMElement;
use JMS\Serializer\XmlSerializationVisitor;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType;
use Jms\Serializer\Annotation;

/**
 * Class for Swedbank-specific fields.
 *
 * @Annotation\AccessType("public_method")
 */
class MethodDetails
{
    /**
     * @var ServiceType
     *
     * @Annotation\XmlElement(cdata=false)
     *
     * @Annotation\SerializedName("ServiceType")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType")
     */
    private $serviceType;

    /**
     * MethodDetails constructor.
     *
     * @param ServiceType $serviceType
     */
    public function __construct(ServiceType $serviceType = null)
    {
        $this->serviceType = $serviceType;
    }

    /**
     * ServiceType getter.
     *
     * @return ServiceType
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * ServiceType setter.
     *
     * @param ServiceType $serviceType
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
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
        /** @var DOMElement $currentNode */
        $currentNode = $visitor->getCurrentNode();
        $currentNode->nodeValue = '';

        if ($this->serviceType !== null && $this->serviceType != ServiceType::undefined()) {
            $serviceTypeNode = $currentNode->ownerDocument->createElement('ServiceType', $this->serviceType->id());
            $currentNode->appendChild($serviceTypeNode);
        }
    }
}
