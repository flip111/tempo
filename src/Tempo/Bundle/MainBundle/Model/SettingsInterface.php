<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Model;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

interface SettingsInterface
{

    /**
     * @return string $name
     */
    public function getName();

    /**
     * @return string $name
     */
    public function getValue();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param string $name
     */
    public function setValue($value);

}