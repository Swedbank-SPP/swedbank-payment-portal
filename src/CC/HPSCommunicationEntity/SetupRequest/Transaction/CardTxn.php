<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the details pertaining to the card transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class CardTxn
{
    /**
     * @const Default method value.
     */
    const METHOD_DEFAULT = 'auth';

    /**
     * Indicates which transaction type is to be used.
     *
     * AUTH indicates that the transaction is to be authorized using the one stage processing model and will be marked
     * for settlement automatically by the gateway.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = self::METHOD_DEFAULT;

    /**
     * CardTxn constructor.
     *
     * @param string $method
     */
    public function __construct($method = self::METHOD_DEFAULT)
    {
        $this->method = $method;
    }

    /**
     * Method getter.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method setter.
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }
}
