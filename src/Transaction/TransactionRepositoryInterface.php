<?php

namespace SwedbankPaymentPortal\Transaction;

use SwedbankPaymentPortal\Transaction\TransactionContainer;

/**
 * Abstract cache for caching some results to be used in later queries.
 */
interface TransactionRepositoryInterface
{
    /**
     * Persists container of transaction frames.
     *
     * @param TransactionContainer $transactionContainer
     */
    public function persist(TransactionContainer $transactionContainer);

    /**
     * Returns the container of transaction frames.
     *
     * @param string $key
     *
     * @return TransactionContainer
     */
    public function get($key);

    /**
     * Deletes transaction container.
     *
     * @param string $key
     *
     * @return bool Whether the delete was successful.
     */
    public function remove($key);

    /**
     * Returns unsettled transactions.
     *
     * @return TransactionContainer[]
     */
    public function getPendingTransactions();
}
