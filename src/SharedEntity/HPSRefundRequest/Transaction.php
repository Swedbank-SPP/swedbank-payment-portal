<?php

namespace SwedbankPaymentPortal\SharedEntity\HPSRefundRequest;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction\HistoricTxn;
use SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction\TxnDetails;

/**
 * Class HPSRefundRequest.
 *
 * @Annotation\AccessType("public_method")
 */
class Transaction
{
    /**
     * The container for Gateway authentication.
     *
     * @var HistoricTxn
     *
     * @Annotation\SerializedName("HistoricTxn")
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction\HistoricTxn")
     */
    private $historicTxn;
    
    /**
     * The container for amount.
     *
     * @var TxnDetails
     *
     * @Annotation\SerializedName("TxnDetails")
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\HPSRefundRequest\Transaction\TxnDetails")
     */
    private $txnDetails;

    /**
     * Transaction constructor.
     *
     * @param HistoricTxn $historicTxn
     * @param TxnDetails $txnDetails
     */
    public function __construct(HistoricTxn $historicTxn, TxnDetails $txnDetails)
    {
        $this->historicTxn = $historicTxn;
        $this->txnDetails = $txnDetails;
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
}
