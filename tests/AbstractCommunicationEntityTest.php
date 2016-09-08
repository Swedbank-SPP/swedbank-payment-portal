<?php

namespace Tests;

use SwedbankPaymentPortal\Container;
use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\SharedEntity\Authentication;

/**
 * Abstract test for communication entities.
 */
abstract class AbstractCommunicationEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $serviceOptions = new ServiceOptions(
            new CommunicationOptions(
                ''
            ),
            new Authentication(
                '',
                ''
            )
        );

        $container = new Container();
        $this->serializer = $container->getContainer($serviceOptions)->get('pg.serializer');
    }
}
