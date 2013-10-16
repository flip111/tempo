<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Tempo\Bundle\MainBundle\Resource\ResourceManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class Behavior extends Helper
{

    protected $resourceManager;
    protected $router;
    protected $onload = array();
    protected $behavior = array();

    /**
     * @param ResourceManager $resourceManager
     */
    public function __construct(ResourceManager $resourceManager, $router)
    {
        $this->resourceManager = $resourceManager;
        $this->router = $router;
    }

    /**
     * @return \Tempo\Bundle\MainBundle\Resource\ResourceManager
     */
    public function getResourceManager()
    {
        return $this->resourceManager;
    }

    /**
     * @param $name
     * @param array $options
     */
    public function init($behavior, array $options)
    {
        $this->behavior[$behavior][] = $options;

    }
    /**
     *  Registers a JavaScript code to execute when loading the page, a * Once the DOM is ready.
     * @param string $call Code à exécuter
     */
    public function onload($call)
    {
        $this->onload[] = 'function(){'.$call.'}';
    }

    /**
     * @return string
     */
    public function renderHTML()
    {
        $data = array();


        if ($this->behavior) {
            $behavior = json_encode($this->behavior);
            $this->onload('Tempo.behavior.init('.$behavior.');');
            $this->behavior = array();
        }


        foreach ($this->onload as $func) {
            $data[] = '$('.$func.');';
        }


        if ($data) {
            $data = implode(' ', $data);
            return '<script type="text/javascript">/*<![CDATA[*/'. $data.'/*]]>*/</script>';
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return array
     */
    public function getResource()
    {
        $ressources = array();
        $ressources['javascripts'] = $this->resourceManager->getJavascripts();
        $ressources['stylesheets'] = $this->resourceManager->getStylesheets();

        return $ressources;

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Behavior';
    }

}