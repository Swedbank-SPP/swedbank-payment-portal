<?php

namespace SwedbankPaymentPortal;

use SwedbankPaymentPortal\BankLink\BankLinkService;
use SwedbankPaymentPortal\CC\HCCService\HCCService;
use SwedbankPaymentPortal\CC\HPSService\HPSService;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\PayPal\PayPalService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Entry point to all services provided.
 */
class SwedbankPaymentPortal
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SwedbankPaymentPortal constructor.
     *
     * @param ServiceOptions $serviceOptions
     */
    public function __construct(ServiceOptions $serviceOptions)
    {
        $this->container = (new Container())->getContainer($serviceOptions);
    }

    /**
     * Returns PayPal processing service.
     *
     * @return PayPalService
     */
    public function getPayPalGateway()
    {
        return $this->container->get('pg.paypal_service');
    }

    /**
     * Returns BankLink processing service.
     *
     * @return BankLinkService
     */
    public function getBankLinkGateway()
    {
        return $this->container->get('pg.banklink_service');
    }

    /**
     * Returns hosted pages payment card processing service.
     *
     * @return HPSService
     */
    public function getPaymentCardHostedPagesGateway()
    {
        return $this->container->get('pg.cc.hps_service');
    }

    /**
     * Returns hosted card capture payment card processing service.
     *
     * @return HCCService
     */
    public function getPaymentCardHostedCardCaptureGateway()
    {
        return $this->container->get('pg.cc.hcc_service');
    }

}
