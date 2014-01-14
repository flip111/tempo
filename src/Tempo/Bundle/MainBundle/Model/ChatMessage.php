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

abstract class ChatMessage
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var collection
     */
    protected $room;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var Object
     */
    protected $user;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated(\DateTime $datetime)
    {
        $this->created = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->content;
    }
}
