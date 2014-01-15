<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Controller\Frontend;

use FOS\RestBundle\Controller\FOSRestController;
use Tempo\Bundle\MainBundle\Entity\ChatMessage;
use Tempo\Bundle\MainBundle\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Tempo\Bundle\MainBundle\Form\Type\ChatMessageType;

/**
 * Rest controller for stories
 */
class MessagesController extends FOSRestController
{
    /**
     * Get a single message from this room messages
     * 
     * @param Room $room
     * @param string $chatMessageId
     */
    public function getMessageAction(Room $room, $chatMessageId)
    {
        $message = $room->getChatMessage($chatMessageId);
        if (!$message) {
            throw $this->createNotFoundException('Could not find message ' . $chatMessageId);
        }
        return $message;
    }

    /**
     * Get all messages for a room
     * 
     * @param Room $room
     * @param string $chatMessageId
     */
    public function getMessagesAction(Room $room)
    {
        return $room->getChatMessages();
    }

    /**
     * Create a new message
     */
    public function postMessagesAction(Room $room, Request $request)
    {
        $view = View::create();

        $message = new ChatMessage();
        $message->setRoom($room);
        $message->setUser($this->getUser());

        $form = $this->createForm(new ChatMessageType(), $message);
        $form->submit($request);

        if ($form->isValid()) {
            $dm = $this->getDoctrine()->getManager();
            $room->addChatMessage($message);
            $dm->persist($room);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($message);
        } else {
            $view->setData($form);
        }
        return $view;
    }
}
