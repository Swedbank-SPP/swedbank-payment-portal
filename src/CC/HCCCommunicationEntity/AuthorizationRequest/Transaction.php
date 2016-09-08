<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\TxnDetails;
use Jms\Serializer\Annotation;

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
     * @var TxnDetails
     *
     * @Annotation\SerializedName("TxnDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\TxnDetails")
     */
    private $txnDetails;

    /**
     * The container for the HPS (hosted page) details.
     *
     * @var CardTxn
     *
     * @Annotation\SerializedName("CardTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardTxn")
     */
    private $cardTxn;

    /**
     * Transaction constructor.
     *
     * @param TxnDetails $txnDetails
     * @param CardTxn    $cardTxn
     */
    public function __construct(TxnDetails $txnDetails, CardTxn $cardTxn)
    {
        $this->txnDetails = $txnDetails;
        $this->cardTxn = $cardTxn;
    }

    /**
     * TxnDetails getter.
     *
     * @return TxnDetails
     */
    public function getTxnDetails()
    {
        return $this->txnDetails;
    }

    /**
     * TxnDetails setter.
     *
     * @param TxnDetails $txnDetails
     */
    public function setTxnDetails($txnDetails)
    {
        $this->txnDetails = $txnDetails;
    }

    /**
     * CardTxn getter.
     *
     * @return CardTxn
     */
    public function getCardTxn()
    {
        return $this->cardTxn;
    }

    /**
     * CardTxn setter.
     *
     * @param CardTxn $cardTxn
     */
    public function setCardTxn($cardTxn)
    {
        $this->cardTxn = $cardTxn;
    }
}
