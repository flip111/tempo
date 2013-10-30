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
        $request = $this->getRequest();

        if ($request->get('_route') == 'project_team_add') {

            $category = $this->getDoctrine()->getRepository('TempoProjectBundle:Project')->findOneBySlug($slug);
            $routeSuccess = 'project_show';

        } else {

            $manager = $this->container->get('tempo_project.manager.organization');
            $category = $manager->findOneBySlug($slug);
            $routeSuccess = 'organization_edit';
        }

        $form = $this->createForm(new TeamType());


        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $formData = $form->getData();
            $findUser = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findOneBy(array('username' => $formData['username']));

            $category->addTeam($findUser);
            $this->getManage()->persistAndFlush($category);

            $request->getSession()->getFlashBag()->set('notice', $this->getTranslator()->trans('team.success_add'));

            return $this->redirect($this->generateUrl($routeSuccess, array('slug' => $category->getSlug())));

        }

            return $this->redirect($this->generateUrl($routeSuccess, array('slug' => $category->getSlug()  )));
    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\TeamManager
     * @return mixed
     */
    protected function getManager()
    {
        return $this->get('tempo_project.manager.team');
    }

    /**
     * Get translator.
     *
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
           return $this->get('translator');
    }
}