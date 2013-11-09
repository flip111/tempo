<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/



namespace Tempo\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tempo\Bundle\MainBundle\Entity\Settings;
use Tempo\Bundle\MainBundle\Form\SettingsType;
use Tempo\Bundle\MainBundle\Form\Type\ChatMessageType;


class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $rooms = $em->getRepository('TempoMainBundle:Room')->findAll();
        $roomId = $request->query->get('currentRoom', $rooms[0]->getId());
        $request->getSession()->set('currentRoom', $roomId);
        $currentRoom = $request->getSession()->get('currentRoom');
        $currentRoom = $em->getRepository('TempoMainBundle:Room')->find($currentRoom);
        $form  = $this->createForm(new ChatMessageType());

        return $this->render('TempoMainBundle:Default:dashboard.html.twig', array(
            'rooms' => $rooms,
            'form' => $form->createView(),
            'currentRoom' => array(
                'id' => $currentRoom->getId(),
                'name' => $currentRoom->getName()
            ),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function settingsAction()
    {

        //get all options
        $options = $this->get('Tempo_main.settings_manager')->loadOptions();

        $settings = new Settings();
        $form = $this->createForm(new SettingsType(), $settings,
            array('options' => $options)
        );

        return $this->render('TempoMainBundle:Default:settings.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function helpAction()
    {
         return $this->render('TempoMainBundle:Default:help.html.twig');
    }
}
