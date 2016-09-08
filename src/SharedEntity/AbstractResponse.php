<?php

namespace SwedbankPaymentPortal\SharedEntity;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\Type\AbstractStatus;

/**
 * Class HPSQueryRequest.
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
abstract class AbstractResponse
{
    /**
     * AbstractResponse constructor.
     *
     * @param string $reason
     * @param int    $time
     */
    public function __construct($reason, $time = null)
    {
        $this->time = $time;
        $this->reason = $reason;
    }

    /**
     * Returns sttus of this response.
     *
     * @return AbstractStatus
     */
    abstract public function getStatus();

    /**
     * The UNIX timestamp at which the transaction reached the Payment Provider server.
     *
     * @var int
     *
     * @Annotation\Type("integer")
     */
    protected $time;
    
    /**
     * A descriptor relating to the state of the transaction.
     *
     * @var string
     *
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    protected $reason;

    /**
     * Time getter.
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Time setter.
     *
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Reason getter.
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Reason setter.
     *
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }
}
