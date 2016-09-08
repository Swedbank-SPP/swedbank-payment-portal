<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\HPSTxn;
use SwedbankPaymentPortal\SharedEntity\Transaction\TxnDetails;
use Jms\Serializer\Annotation;
use JMS\Serializer\Annotation\XmlList;

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
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Transaction\TxnDetails")
     */
    private $txnDetails;

    /**
     * The container for the HPS (hosted page) details.
     *
     * @var HPSTxn
     *
     * @Annotation\SerializedName("HpsTxn")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\HPSTxn")
     */
    private $hpsTxn;

    /**
     * The container for the APM transaction
     * @var APMTxn[]
     *
     * @Annotation\Type("array<SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn>")
     * @Annotation\SerializedName("APMTxns")
     * @XmlList(entry = "APMTxn")
     */
    private $apmTxns;

    /**
     * Transaction constructor.
     *
     * @param TxnDetails $txnDetails
     * @param HPSTxn     $hpsTxn
     * @param APMTxn     $apmTxn
     */
    public function __construct(TxnDetails $txnDetails, HPSTxn $hpsTxn, APMTxn $apmTxn)
    {
        $this->txnDetails = $txnDetails;
        $this->hpsTxn = $hpsTxn;
        $this->apmTxns = [$apmTxn];
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

    /**
     * ApmTxns getter.
     *
     * @return APMTxn[]
     */
    public function getApmTxns()
    {
        return $this->apmTxns;
    }

    /**
     * ApmTxns setter.
     *
     * @param APMTxn[] $apmTxns
     */
    public function setApmTxns($apmTxns)
    {
        $this->apmTxns = $apmTxns;
    }
}
