<?php

namespace SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction;

use JMS\Serializer\Annotation;

/**
 * Class QueryRequest.
 *
 * @Annotation\AccessType("public_method")
 */
class Reference
{
    
    /** 
     * The transaction type. The value merchant should be sent in this field
     
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\AccessType("reflection")
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\XmlAttribute 
     */
    private $type = 'merchant';
    
    /**
     * A 16 digit unique identifier for the transaction.
     * This reference will be used when submitting QUERY transactions to the Payment Gateway.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlValue 
     * @Annotation\XmlElement(cdata=false)
     
     */
    private $reference;

    /**
     * HistoricTxn constructor.
     *
     * @param string $reference
     */
    public function __construct($reference)
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
        $this->reference = $reference;
    }
    
    
}
