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
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

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
        $form = $this->createForm(new TeamType());

        if ($request->get('_route') == 'project_team_add') {
            $category = $this->get('tempo_project.manager.project')->findOneBySlug($slug);
            $routeSuccess = 'project_show';

        } else {
            $manager = $this->get('tempo_project.manager.organization');
            $category = $manager->findOneBySlug($slug);
            $routeSuccess = 'organization_edit';
        }

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $formData = $form->getData();
            $findUser = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findOneBy(array('username' => $formData['username']));

            $category->addTeam($findUser);
            $this->getManager()->persist($category);
            $this->getManager()->flush();
            $this->getAclManager()->addObjectPermission($category, MaskBuilder::MASK_VIEW); //set Permission

            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('team.success_add', array(), 'TempoProject'));

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
        return $this->getDoctrine()->getManager();
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

    /**
     * @return object
     */
    protected function getAclManager()
    {
        return $this->get('problematic.acl_manager');
    }
}
