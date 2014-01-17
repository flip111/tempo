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

use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpFoundation\Request;


abstract class BaseContext extends MinkContext implements KernelAwareInterface
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
        // Initialize your context here
        $this->parameters = $parameters;

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
     * Get service by id.
     *
     * @param string $id
     *
     * @return object
     */
    private function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * Returns Container instance.
     *
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Generate url.
     *
     * @param string  $route
     * @param array   $parameters
     * @param Boolean $absolute
     *
     * @return string
     */
    protected function generateUrl($route, array $parameters = array(), $absolute = false)
    {
        return $this->getService('router')->generate($route, $parameters, $absolute);
    }

    /**
     * Generate page url from name and parameters.
     *
     * @param string $page
     * @param array  $parameters
     *
     * @return string
     */
    protected  function generatePageUrl($page, array $parameters = array())
    {
        $parts = explode(' ', trim($page), 2);
        if (2 === count($parts)) {
            $parts[1] = Inflector::camelize($parts[1]);
        }

        $route  = implode('_', $parts);
        $routes = $this->getContainer()->get('router')->getRouteCollection();

        if (null === $routes->get($route)) {
            $route = 'app_'.$route;
        }

        return $this->getMinkParameter('base_url').$this->generateUrl($route, $parameters);
    }

    private function unescape($argument)
    {
        return str_replace('""', '"', $argument);
    }

    private function escape($argument)
    {
        return str_replace('"', '""', $argument);
    }

    /**
     * Wait
     *
     * @param integer $time
     * @param string  $condition
     *
     * @throws BehaviorException If timeout is reached
     */
    public function wait($time = 10000, $condition = null)
    {
        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            return;
        }

        $start = microtime(true);
        $end = $start + $time / 1000.0;

        $condition = $condition !== null ? $condition : <<<JS
        document.readyState == 'complete'                  // Page is ready
            && typeof $ != 'undefined'                     // jQuery is loaded
            && !$.active                                   // No ajax request is active
            && $('#page').css('display') == 'block'        // Page is displayed (no progress bar)
            && $('.loading-mask').css('display') == 'none' // Page is not loading (no black mask loading page)
            && $('.jstree-loading').length == 0;           // Jstree has finished loading
JS;

        // Make sure the AJAX calls are fired up before checking the condition
        $this->getSession()->wait(100, false);

        $this->getSession()->wait($time, $condition);

        // Check if we reached the timeout unless the condition is false to explicitly wait the specified time
        if ($condition !== false && microtime(true) > $end) {
            throw new BehaviorException(sprintf('Timeout of %d reached when checking on %s', $time, $condition));
        }
    }

}
