<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest;

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
     * @var TxnDetails
     *
     * @Annotation\SerializedName("TxnDetails")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction\TxnDetails")
     */
    private $txnDetails;

    /**
     * The container for the HPS (hosted page) details.
     *
     * @var HPSTxn
     *
     * @Annotation\SerializedName("HpsTxn")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction\HPSTxn")
     */
    private $hpsTxn;

    /**
     * Transaction constructor.
     *
     * @param TxnDetails $txnDetails
     * @param HPSTxn     $hpsTxn
     */
    public function __construct(TxnDetails $txnDetails, HPSTxn $hpsTxn)
    {
        $this->txnDetails = $txnDetails;
        $this->hpsTxn = $hpsTxn;
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
