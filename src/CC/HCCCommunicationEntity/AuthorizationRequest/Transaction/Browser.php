<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;

use JMS\Serializer\Annotation;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;
use JMS\Serializer\Context;

/**
 * Marks device type.
 */
class Browser
{
    /**
     * Device type.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $deviceCategory;

    /**
     * Browser constructor.
     *
     * @param string $deviceCategory
     */
    public function __construct($deviceCategory)
    {
        $this->deviceCategory = $deviceCategory;
    }

    /**
     * DeviceCategory getter.
     *
     * @return string
     */
    public function getDeviceCategory()
    {
        return $this->deviceCategory;
    }

    /**
     * DeviceCategory setter.
     *
     * @param string $deviceCategory
     */
    public function setDeviceCategory($deviceCategory)
    {
        $this->deviceCategory = $deviceCategory;
    }
}
