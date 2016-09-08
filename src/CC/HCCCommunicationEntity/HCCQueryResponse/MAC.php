<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse;

use JMS\Serializer\Annotation;

/**
 * The container for the MAC information.
 *
 * @Annotation\AccessType("public_method")
 */
class MAC
{
    /**
     * Outcome
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $outcome;

    /**
     * MAC constructor.
     *
     * @param string $outcome
     */
    public function __construct($outcome)
    {
        $this->outcome = $outcome;
    }

    /**
     * Outcome getter.
     *
     * @return string
     */
    public function getOutcome()
    {
        return $this->outcome;
    }

    /**
     * Outcome setter.
     *
     * @param string $outcome
     */
    public function setOutcome($outcome)
    {
        $this->outcome = $outcome;
    }
}
