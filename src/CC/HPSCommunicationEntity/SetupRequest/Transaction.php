<?php

namespace SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest;

use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\CardTxn;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\HPSTxn;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\TxnDetails;
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
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\TxnDetails")
     */
    private $txnDetails;

    /**
     * HPS transaction.
     *
     * @var HPSTxn
     *
     * @Annotation\SerializedName("HpsTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\HPSTxn")
     */
    private $hpsTxn;

    /**
     * The container for the HPS (hosted page) details.
     *
     * @var CardTxn
     *
     * @Annotation\SerializedName("CardTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\CardTxn")
     */
    private $cardTxn;

    /**
     * Transaction constructor.
     *
     * @param TxnDetails $txnDetails
     * @param HPSTxn     $hpsTxn
     * @param CardTxn    $cardTxn
     */
    public function __construct(TxnDetails $txnDetails, HPSTxn $hpsTxn, CardTxn $cardTxn)
    {
        $this->txnDetails = $txnDetails;
        $this->hpsTxn = $hpsTxn;
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

    /**
     * HpsTxn getter.
     *
     * @return HPSTxn
     */
    public function getHpsTxn()
    {
        return $this->hpsTxn;
    }

    /**
     * HpsTxn setter.
     *
     * @param HPSTxn $hpsTxn
     */
    public function setHpsTxn($hpsTxn)
    {
        $this->hpsTxn = $hpsTxn;
    }
}
