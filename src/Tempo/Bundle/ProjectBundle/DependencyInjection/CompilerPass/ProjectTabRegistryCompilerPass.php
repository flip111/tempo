<?php

namespace Tempo\Bundle\ProjectBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ProjectTabRegistryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tempo.project.registry.providers')) {
            return;
        }

        $definition = $container->getDefinition(
            'tempo.project.registry.providers'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'tempo.project.show.tab'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addProvider',
                array(new Reference($id))
            );
        }
    }
}