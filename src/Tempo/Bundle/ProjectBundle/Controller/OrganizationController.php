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

use Tempo\Bundle\ProjectBundle\Entity\Organization;
use Tempo\Bundle\ProjectBundle\Form\Type\OrganizationType;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;


/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationController extends Controller
{
    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $organization = $this->findOrganization($slug);
        $csrfToken = $this->get('form.csrf_provider')->generateCsrfToken('delete-organization');


        if (false === $this->get('security.context')->isGranted('VIEW', $organization)) {
            throw new AccessDeniedException();
        }

        $manager = $this->get('tempo_project.manager.organization');
        $counter = $manager->getStatusProjects($organization->getId());

        $breadcrumb = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Organization');
        $breadcrumb->addChild($organization->getName());

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Organization:show.html.twig', array(
            'organization' => $organization,
            'counter' => $counter,
            'projects' => $organization->getProjects(),
            'teamForm' => $teamForm,
            'csrfToken' => $csrfToken
        ));
    }

    /**
     * Create new organization
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new OrganizationType(), new Organization(), array('is_new' => true));

        return $this->render('TempoProjectBundle:Organization:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($slug)
    {
        $organization = $this->findOrganization($slug);

        if (false === $this->get('security.context')->isGranted('EDIT', $organization)) {
            throw new AccessDeniedException();
        }

        $breadcrumb = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Organization');
        $breadcrumb->addChild($organization->getName());
        $breadcrumb->addChild('Editer le organization');

        $editForm = $this->createForm(new OrganizationType(), $organization);

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Organization:edit.html.twig', array(
            'organization' => $organization,
            'form' => $editForm->createView(),
            'teamForm' => $teamForm->createView(),
        ));
    }

    /**
     * Edits an existing Organization entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction($id)
    {
        $manager = $this->get('tempo_project.manager.organization');
        $request = $this->getRequest();

        $organization = $manager->find($id);

        if (false === $this->get('security.context')->isGranted('EDIT', $organization)) {
            throw new AccessDeniedException();
        }

        $editForm = $this->createForm(new OrganizationType(), $organization);

        if ($request->isMethod('POST') && $editForm->submit($request)->isValid()) {
            $manager->persistAndFlush($organization);
            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('organization.success_deleted', array(), 'TempoProject'));

            return $this->redirect($this->generateUrl('organization_show', array('slug' => $organization->getSlug())));
        }

        return $this->render('TempoProjectBundle:Organization:edit.html.twig', array(
            'organization' => $organization,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Create a organization
     * @return array
     */
    public function createAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $request = $this->getRequest();

        $organization = new Organization();
        $organization->addTeam($this->getUser());

        $form = $this->createForm(new OrganizationType(), $organization);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $this->getManager()->persistAndFlush($organization);
            $this->getAclManager()->addObjectPermission($organization, MaskBuilder::MASK_OWNER); //set Permission
            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('organization.success_create', array(), 'TempoProject'));

            return $this->redirect($this->generateUrl('organization_edit', array('slug' => $organization->getSlug())));
        }
    }

    /**
     * Delete a organization
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($slug)
    {
        $request = $this->getRequest();
        $organization = $this->findOrganization($slug);

        if (false === $this->get('security.context')->isGranted('DELETE', $organization)) {
            throw new AccessDeniedException();
        }

        //check CSRF token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid('delete-organization', $request->get('token'))) {
            throw new AccessDeniedHttpException('Invalid CSRF token.');
        }

        try {

            $this->getManager()->removeAndFlush($organization);
            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('organization.success_delete', array(), 'TempoProject'));

            return $this->redirect($this->generateUrl('project_home'));

        } catch (\InvalidArgumentException $e) {
            $request->getSession()->getFlashBag()->set('error', $this->getTranslator()->trans('organization.failed_delete', array(), 'TempoProject'));

            return $this->redirect($this->generateUrl('organization_show', array('slug' => $organization->getSlug() )));
        }

    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\OrganizationManager
     * @return mixed
     */
    private function getManager()
    {
        return $this->get('tempo_project.manager.organization');
    }

    /**
     * @param $slug
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function findOrganization($slug)
    {
        return $this->getManager()->findOneBySlug($slug);
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

    protected function getAclManager()
    {
        return $this->get('problematic.acl_manager');
    }
}