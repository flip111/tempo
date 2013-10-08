<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @todo generate automatique Breadcrumb
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        /* set breadcrumb */
        $breadcrumb  = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Project');

        $manager = $this->container->get('tempo_project.manager.client');
        $clients = $manager->findAllByUser($this->getUser()->getId());

        return $this->render('TempoProjectBundle:Default:index.html.twig',
            array('clients' => $clients)
        );
    }
}
