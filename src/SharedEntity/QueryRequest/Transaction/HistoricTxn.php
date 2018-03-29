<?php

namespace SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction\Reference;

/**
 * Class QueryRequest.
 *
 * @Annotation\AccessType("public_method")
 */
class HistoricTxn
{
    
    
    /**
     * The transaction type. The value query should be sent in this field
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\AccessType("reflection")
     * @Annotation\XmlElement(cdata=false)
     */
    private $method = 'query';

    /**
     * The container for Gateway authentication.
     *
     * @var Reference
     *
     * @Annotation\SerializedName("reference")
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction\Reference")
     */
    private $reference;

    /**
     * HistoricTxn constructor.
     *
     * @param string $reference
     */
    public function __construct(Reference $reference)
    {
        $this->reference = $reference;
    }

    /**
     * Reference getter.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Reference setter.
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $references;
    }
    
}
