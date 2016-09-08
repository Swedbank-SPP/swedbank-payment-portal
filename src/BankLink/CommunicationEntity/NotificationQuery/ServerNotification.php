<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery;

use JMS\Serializer\Annotation;

/**
 * A notification which system sends to merchant every once in a while.
 *
 * @Annotation\AccessType("public_method")
 */
class ServerNotification
{
    /**
     * The version used for the APM's complex structure. The value 2 will be returned in this field.
     *
     * @var string
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("string")
     */
    private $version;

    /**
     * The version used for the APM's complex structure. The value 2 will be returned in this field.
     *
     * @var string
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("string")
     * @Annotation\SerializedName("AccountName")
     */
    private $accountName;

    /**
     * The top-level container for the type of event that this response refers to.
     *
     * @var Event
     *
     * @Annotation\SerializedName("Event")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\Event")
     */
    private $event;

    /**
     * ServerNotification constructor.
     *
     * @param string $version
     * @param string $accountName
     * @param Event  $event
     */
    public function __construct($version, $accountName, Event $event)
    {
        $this->version = $version;
        $this->accountName = $accountName;
        $this->event = $event;
    }

    /**
     * Version getter.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Version setter.
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * AccountName getter.
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * AccountName setter.
     *
     * @param string $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }

    /**
     * ApmTxn getter.
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * ApmTxn setter.
     *
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }
}
