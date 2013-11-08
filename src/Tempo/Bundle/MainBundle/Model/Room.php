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


abstract class Room
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    protected $team;

    protected $chatMessages;


    public function __construct()
    {
        $this->chatMessages = new ArrayCollection();
        $this->team = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
       $this->name = $name;
    }

    /**
     * Add chatMessage
     *
     * @param ChatMessage $chatMessage
     */
    public function addChatMessage(ChatMessage $chatMessage)
    {
        $this->chatMessages[] = $chatMessage;
    }

    /**
     * Get chatMessages
     *
     * @return ArrayCollection $chatMessages
     */
    public function getChatMessages()
    {
        return $this->chatMessages;
    }

    /**
     * Get a specfic chat message
     *
     * @param type $id
     * @return ChatMessage
     */
    public function getChatMessage($id)
    {
        foreach ($this->chatMessages as $message) {
            if ($id == $message->getId()) {
                return $message;
            }
        }
        return null;
    }


}