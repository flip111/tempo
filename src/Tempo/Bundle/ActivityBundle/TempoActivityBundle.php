<?php

namespace Tempo\Bundle\ActivityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tempo\Bundle\ActivityBundle\DependencyInjection\Compiler\RegisterProviderPass;

class TempoActivityBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterProviderPass());
    }
}
