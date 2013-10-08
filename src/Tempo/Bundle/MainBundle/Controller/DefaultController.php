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
use Tempo\MainBundle\Entity\Settings;
use Tempo\MainBundle\Form\SettingsType;


class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('TempoMainBundle:Default:index.html.twig');
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
