<?php

namespace SwedbankPaymentPortal\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SerializerCompilerPass.
 */
class SerializerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('pg.serializer')) {
            return;
        }

        $definition = $container->findDefinition('pg.serializer');

        $taggedServices = $container->findTaggedServiceIds('serializer.subscriber');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addSubscriber',
                [new Reference($id)]
            );
        }
    }
}
