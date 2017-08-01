<?php

namespace SwedbankPaymentPortal\Transaction;


use Doctrine\Common\Cache\Cache;
use SwedbankPaymentPortal\Serializer;

class TransactionRepositoryFactory implements TransactionRepositoryFactoryInterface
{
    private $TRANSACTION_TIMEOUT_INTERVAL = 30;

    /**
     * @var TransactionRepository[]
     */
    private $repositories = [];

    /**
     * @var Cache|null
     */
    private $customCacheImplementation;

    /**
     * TransactionRepositoryFactory constructor.
     *
     * @param Cache|null $customCacheImplementation optionally you can specify your own Cache implementation for transactions storage.
     */
    public function __construct(Cache $customCacheImplementation = null)
    {
        $this->customCacheImplementation = $customCacheImplementation;
    }

    /**
     * {@inheritdoc}
     */
    public function createRepository(Serializer $serializer, $name)
    {
        return isset($this->repositories[$name]) ? $this->repositories[$name] : $this->repositories[$name] = new TransactionRepository($serializer, $name, $this->TRANSACTION_TIMEOUT_INTERVAL, $this->customCacheImplementation);
    }
}