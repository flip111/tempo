<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Behat;

use Behat\Behat\Context\Step;
use Behat\Behat\Context\Step\When;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

use Behat\MinkExtension\Context\RawMinkContext;



/**
 * Features context.
 */
class FeatureContext extends RawMinkContext implements KernelAwareInterface
{

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('web-user', new WebUser());

        Request::enableHttpMethodParameterOverride();
    }

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^I am on route "([^"]*)"$/
     */
    public function iAmOnRoute($route)
    {
        $route = $this->kernel->getContainer()->get('router')->generate($route, array(), false);
        $this->getSession()->visit($this->getMinkParameter('base_url').$route);
    }

}
