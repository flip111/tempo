<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Twig\Extension;

use Knp\Bundle\TimeBundle\Templating\Helper\TimeHelper;
use Tempo\Bundle\CoreBundle\Imagine\Cache\CacheManager;

use Ikimea\Browser\Browser;

class MainExtension extends \Twig_Extension
{

    private $container;
    private $helper;

    /**
     * @param $container
     */
    public function __construct($container, TimeHelper $helper, CacheManager $cacheManager)
    {
        $this->container = $container;
        $this->helper = $helper;
        $this->cacheManager = $cacheManager;

    }

    /**
     * {@inheritdoc}
     */
    public function getFilters() {
        return array(
            'size' => new \Twig_Filter_Method($this, 'size'),
            'datetime_diff' => new \Twig_Filter_Method($this, 'dateTimeDiff'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'datetime_diff'  => new \Twig_Function_Method($this, 'dateTimeDiff', array(
                'is_safe' => array('html')
            )),
            'get_browser' => new \Twig_Function_Method($this, 'getBrowser'),
            'behavior' => new \Twig_Function_Method($this, 'getBehavior'),
            'icon' => new \Twig_Function_Method($this, 'getIcon'),
        );
    }

    /**
     * calcule size file
     * @param $size
     * @return string
     */
    public function size($size)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2).$units[$i];
    }

    public function dateTimeDiff($since = null, $to = null, $seconde = 'H:i:s')
    {
        if( null !== $since  && strtotime($since->format('Y-m-d H:i:s')) <= strtotime('+3 days')) {
           return $this->container->get('request')->getLocale() == 'fr' ? $since->format('d/m/Y '.$seconde) : $since->format('Y-m-d '.$seconde) ;
        }
        return $this->helper->diff($since, $to);
    }

    public function getIcon($path, $size = null)
    {
        if (null == $size) {
            return $path;
        }

        return $this->cacheManager->getBrowserPath($path, $size);

    }

    /**
     * @return string
     */
    public function getBrowser()
    {
        $browser = new Browser() ;
        $navigateurFinal = explode('.', $browser->getVersion() );

        return strtolower($browser->getBrowser(). ' ' .
            $browser->getBrowser().$navigateurFinal[0]). ' '.
            $browser->getPlatform();
    }

    /**
     *  @return Tempo\Bundle\MainBundle\Helper\Behavior
     */
    public function getBehavior()
    {
        return $this->container->get('tempo_main.behavior');
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
       return 'MainExtension';
    }
}