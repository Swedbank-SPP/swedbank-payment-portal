<?php

namespace SwedbankPaymentPortal\Transaction;


use SwedbankPaymentPortal\Transaction\TransactionRepositoryFactoryInterface;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\Transaction\TransactionRepository;

class TransactionRepositoryFactory implements TransactionRepositoryFactoryInterface
{
    /**
     * @var TransactionRepository[]
     */
    private $repositories = [];

    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createRepository(Serializer $serializer, $name)
    {
        return isset($this->repositories[$name]) ? $this->repositories[$name] : $this->repositories[$name] = new TransactionRepository($serializer, $name);
    }
}