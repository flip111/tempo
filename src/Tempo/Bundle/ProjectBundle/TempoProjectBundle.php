<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tempo\Bundle\ProjectBundle\DependencyInjection\CompilerPass\ProjectTabRegistryCompilerPass;

class TempoProjectBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProjectTabRegistryCompilerPass());
    }
}
