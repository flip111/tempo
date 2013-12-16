<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Resource;


/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

interface ResourceManagerInterface
{
    /**
     * @abstract
     * @param $resource
     */
    function requireResource($resource);

    /**
     * @abstract
     * @param array $resources
     */
    function requireResources(array $resources);

    /**
     * return all css
     * @return array
     */
    function getStylesheets();

    /**
     * return all javascripts
     * @return array
     */
    function getJavascripts();
}
