<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction;

use JMS\Serializer\Annotation;

/**
 * The container for the HPS (hosted page) details.
 *
 * @Annotation\AccessType("public_method")
 */
class HPSTxn
{
    /**
     * The Page Set ID which corresponds to the Hosted Page configuration onthe Gateway.
     *
     * @var int
     *
     * @Annotation\Type("integer")
     */
    private $pageSetId = 1;

    /**
     * Indicates the Hosted Method to be used. Value must match = “setup_full”.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = 'setup_full';

    /**
     * HPSTxn constructor.
     *
     * @param int $pageSetId
     */
    public function __construct($pageSetId = 1)
    {
        $this->pageSetId = $pageSetId;
    }

    /**
     * PageSetId getter.
     *
     * @return int
     */
    public function getPageSetId()
    {
        return $this->pageSetId;
    }

    /**
     * PageSetId setter.
     *
     * @param int $pageSetId
     */
    public function setPageSetId($pageSetId)
    {
        $this->pageSetId = $pageSetId;
    }

    /**
     * Method getter.
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method setter.
     *
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }
}
