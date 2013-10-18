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

use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/*
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class TeamController extends Controller
{
    /**
     * @param $slug
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction($slug)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        if ($this->getRequest()->get('_route') == 'project_team_add') {

            $category = $this->getDoctrine()->getRepository('TempoProjectBundle:Project')->findOneBySlug($slug);
            $routeSuccess = 'project_show';

        } else {

            $manager = $this->container->get('tempo_project.manager.client');
            $category = $manager->findOneBySlug($slug);
            $routeSuccess = 'client_edit';
        }

        $form = $this->createForm(new TeamType());

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $formData = $form->getData();
                $findUser = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findOneBy(array('username' => $formData['username']));

                $category->addTeam($findUser);
                $em->persist($category);
                $em->flush();

                $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('L\'utilisateur a bien été ajouté à l\'équipe !'));

                return $this->redirect($this->generateUrl($routeSuccess, array('slug' => $category->getSlug()  )));
            }

        }
        return $this->redirect($this->generateUrl($routeSuccess, array('slug' => $category->getSlug()  )));


    }
}
