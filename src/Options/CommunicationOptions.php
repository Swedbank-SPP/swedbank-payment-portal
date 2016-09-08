<?php

namespace SwedbankPaymentPortal\Options;

class CommunicationOptions
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * CommunicationOptions constructor.
     *
     * @param string $endpoint
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Endpoint getter.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Endpoint setter.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
