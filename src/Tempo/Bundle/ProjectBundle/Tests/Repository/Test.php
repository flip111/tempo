<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tests\Repository;

use Tempo\ProjectBundle\Tests\Test as BaseTestCase;

abstract class Test extends BaseTestCase
{
    public function setUp()
    {
        self::createTempoKernel();

        // Load "test" entity manager
        static::$em = static::$kernel->getContainer()->get('doctrine')->getEntityManager();
    }
}
