<?php

namespace SwedbankPaymentPortal\SharedEntity\QueryRequest;

use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction\HistoricTxn;

/**
 * Class QueryRequest.
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
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\QueryRequest\Transaction\HistoricTxn")
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
