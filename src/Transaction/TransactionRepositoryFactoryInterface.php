<?php
namespace SwedbankPaymentPortal\Transaction;


use SwedbankPaymentPortal\Transaction\TransactionRepositoryInterface;
use SwedbankPaymentPortal\Serializer;

interface TransactionRepositoryFactoryInterface
{
    /**
     * @param Serializer $serializer
     * @param string     $name
     * @return TransactionRepositoryInterface
     */
    public function createRepository(Serializer $serializer, $name);
}