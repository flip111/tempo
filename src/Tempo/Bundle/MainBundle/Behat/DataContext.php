<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Behat;

use Behat\Behat\Context\BehatContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Faker\Factory as FakerFactory;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\MinkExtension\Context\RawMinkContext;


class DataContext extends RawMinkContext
{
    /**
     * Faker.
     *
     */
    private $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }
}
