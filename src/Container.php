<?php

namespace SwedbankPaymentPortal;

use Doctrine\Common\Annotations\AnnotationRegistry;
use SwedbankPaymentPortal\Compiler\SerializerCompilerPass;
use SwedbankPaymentPortal\Options\ServiceOptions;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Container using Symfony DI component.
 */
class Container
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Initializes and returns container.
     *
     * @param ServiceOptions $serviceOptions
     * @return ContainerInterface
     */
    public function getContainer(ServiceOptions $serviceOptions)
    {
        AnnotationRegistry::registerLoader('class_exists');

        if ($this->container) {
            return $this->container;
        }

        $this->container = new ContainerBuilder(new ParameterBag(['service_options' => $serviceOptions]));
        $this->loadConfigs($this->container);
        $this->container->addCompilerPass(new SerializerCompilerPass());
        $this->container->compile();

        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadConfigs(ContainerBuilder $containerBuilder)
    {
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/config'));
        $loader->load('services.yml');
    }
}
