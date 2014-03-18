<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tempo\Bundle\MainBundle\Entity\Settings;
use Tempo\Bundle\MainBundle\Form\SettingsType;
use Tempo\Bundle\MainBundle\Form\Type\ChatMessageType;

class DashboardController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rooms = $em->getRepository('TempoMainBundle:Room')->findAll();
        $roomId = $request->query->get('currentRoom', $rooms[0]->getId());
        $request->getSession()->set('currentRoom', $roomId);
        $currentRoom = $em->getRepository('TempoMainBundle:Room')->find( $request->getSession()->get('currentRoom'));
        $form  = $this->createForm(new ChatMessageType());

        return $this->render('TempoMainBundle:Default:dashboard.html.twig', array(
            'rooms' => $rooms,
            'form' => $form->createView(),
            'currentRoom' => array(
                'id' => $currentRoom->getId(),
                'name' => $currentRoom->getName(),
            ),
            'project' => $currentRoom->getProject(),
        ));
    }
}
