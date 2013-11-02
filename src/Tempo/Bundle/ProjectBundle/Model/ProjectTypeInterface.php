<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Model;

interface ProjectTypeInterface
{
    /**
     * @return integer $id
     */
    public function getId();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string $name
     */
    public function getName();
}