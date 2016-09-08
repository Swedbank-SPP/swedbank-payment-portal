<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container that contains the data to be risk screened.
 *
 * @Annotation\AccessType("public_method")
 */
class Risk
{
    /**
     * This will indicate when if the transaction is to be screened pre or post authorisation.
     *
     * @var Action
     *
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\Action")
     * @Annotation\SerializedName("Action")
     */
    private $action;

    /**
     * Risk constructor.
     *
     * @param Action $action
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    /**
     * Action getter.
     *
     * @return Action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Action setter.
     *
     * @param Action $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}
