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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class Test extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $em;

    /**
     * Creates a Kernels.
     *
     * @see Symfony\Bundle\FrameworkBundle\Test\WebTestCase::createKernel
     *
     * @param array $options An array of options
     */
    public static function createTempoKernel(array $options = array())
    {
        static::$kernel = static::createKernel($options);
        static::$kernel->boot();
    }

    /**
     * EntityManager getter
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return static::$em;
    }

    protected static function getKernelClass()
    {
        require_once __Dir__.'/AppTestKernel.php';

        return 'Tempo\ProjectBundle\Tests\AppTestKernel';
    }

}
