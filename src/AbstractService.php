<?php

namespace SwedbankPaymentPortal;

use SwedbankPaymentPortal\Transaction\TransactionRepositoryInterface;
use SwedbankPaymentPortal\Options\ServiceOptions;

/**
 * Abstract service for a payment type.
 */
abstract class AbstractService
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var AbstractCommunication
     */
    protected $communication;

    /**
     * @var ServiceOptions
     */
    protected $serviceOptions;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * AbstractService constructor.
     *
     * @param ServiceOptions        $serviceOptions
     * @param AbstractCommunication $communication
     * @param Serializer            $serializer
     */
    public function __construct(ServiceOptions $serviceOptions, AbstractCommunication $communication, Serializer $serializer)
    {
        $this->serviceOptions = $serviceOptions;
        $this->communication = $communication;
        $this->serializer = $serializer;

        $this->communication->setOptions($serviceOptions->getCommunicationOptions());
        $this->communication->setLogger($this->serviceOptions->getLogger());
    }


    /**
     * Communication getter.
     *
     * @return AbstractCommunication
     */
    public function getCommunication()
    {
        return $this->communication;
    }

    /**
     * Returns transaction repository.
     *
     * @return TransactionRepositoryInterface
     */
    protected function getTransactionRepository()
    {
        $transactionRepositoryFactory = $this->serviceOptions->getTransactionRepositoryFactory();

        return $this->transactionRepository ? $this->transactionRepository : $this->transactionRepository = $transactionRepositoryFactory->createRepository(
            $this->serializer,
            get_class($this)
        );
    }
}
