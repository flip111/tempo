<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Model;

/**
 * Activity
 *
 */
class Activity implements ActivityInterface
{
    /**
     * @var integer
     *
     */
    protected  $id;

    /**
     * @var string
     *
     */
    protected $provider;

    /**
     * @var \DateTime
     *
     */
    protected $created;

    /**
     * @var string
     *
     */
    protected $message;

    /**
     * @var array
     *
     */
    protected $parameters;

    public function __toString()
    {
        return $this->getMessage();
    }

    /**
     * {inheritedDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {inheritedDoc}
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * {inheritedDoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {inheritedDoc}
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {inheritedDoc}
     */
    public function setCreated($datetime)
    {
        $this->created = $datetime;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($decoder = 'unserialize')
    {
        return $decoder($this->parameters);
    }
}
