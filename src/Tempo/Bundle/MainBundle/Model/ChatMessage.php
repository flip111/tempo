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

class ChatMessage
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
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ChatMessage
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return ChatMessage
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set datetime
     *
     * @param DateTime $datetime
     * @return ChatMessage
     */
    public function setCreated(\DateTime $datetime)
    {
        $this->created = $datetime;
        return $this;
    }

    /**
     * Get datetime
     *
     * @return date $datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return $room
     */
    public function getRoom()
    {
        return $this->room;
    }

    public function __toString()
    {
        return (string) $this->content;
    }
}