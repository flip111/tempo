<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tests;

// get the autoload file
$dir = __DIR__;
$lastDir = null;
while ($dir !== $lastDir) {
    $lastDir = $dir;

    if (is_file($dir.'/autoload.php')) {
        require_once $dir.'/autoload.php';
        break;
    }

    if (is_file($dir.'/autoload.dist.php')) {
        require_once $dir.'/autoload.dist.php';
        break;
    }

    $dir = dirname($dir);
}

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * AppTestKernel is a test kernel for the TheodoRogerCmsBunde
 */
class AppTestKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \Tempo\Bundle\ProjectBundle\TempoProjectBundle(),
            new \Tempo\Bundle\UserBundle\TempoUserBundle(),
            new \FOS\UserBundle\FOSUserBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle()

        );

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/Fixtures/app/config/config.yml');
    }
}
