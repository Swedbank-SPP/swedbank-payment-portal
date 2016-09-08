<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction\HPSTxn;
use Jms\Serializer\Annotation;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction\TxnDetails;

/**
 * The container for the transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class Transaction
{
    /**
     * The container transaction details.
     *
     * @var HistoricTxn
     *
     * @Annotation\SerializedName("HistoricTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\HistoricTxn")
     */
    private $historicTxn;

    /**
     * Transaction constructor.
     *
     * @param HistoricTxn $historicTxn
     */
    public function __construct(HistoricTxn $historicTxn)
    {
        $this->historicTxn = $historicTxn;
    }

    /**
     * HistoricTxn getter.
     *
     * @return HistoricTxn
     */
    public function getHistoricTxn()
    {
        return $this->historicTxn;
    }

    /**
     * HistoricTxn setter.
     *
     * @param HistoricTxn $historicTxn
     */
    public function setHistoricTxn($historicTxn)
    {
        $this->historicTxn = $historicTxn;
    }
}
