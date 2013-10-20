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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

        $manager = $this->container->get('tempo_project.manager.organization');
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

        $editForm = $this->createForm(new OrganizationType(), $organization);

        if ($request->getMethod() == "POST") {

            $editForm->submit($request);

            if ($editForm->isValid()) {

                $manager->persistAndFlush($organization);

                $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('Le organization a bien été mis à jour avec succès !'));

                return $this->redirect($this->generateUrl('organization_show', array('slug' => $organization->getSlug()  )));
            }
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
        $request = $this->getRequest();

        $organization = new Organization();
        $organization->addTeam($this->getUser());

        $form = $this->createForm(new OrganizationType(), $organization);
        $form->setData($organization);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $em = $this->container->get('doctrine.orm.entity_manager');
                $em->persist($organization);
                $em->flush();

                $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('Organization ajouté avec succès !'));

                return $this->redirect($this->generateUrl('organization_edit', array('slug' => $organization->getSlug() )));
            }
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
        $em = $this->getDoctrine()->getManager();
        $organization = $this->findOrganization($slug);

        //check CSRF token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid('delete-organization', $request->get('token'))) {
            throw new AccessDeniedHttpException('Invalid CSRF token.');
        }

        try {

            $em->remove($organization);
            $em->flush();
            $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('Organization supprimé avec succès !'));

            return $this->redirect($this->generateUrl('project_home'));

        } catch (\Exception $e) {

            $this->get('session')->getFlashBag()->set('error', $this->get('translator')->trans('Impossible de supprimer l\'organization'));

            return $this->redirect($this->generateUrl('organization_show', array('slug' => $organization->getSlug() )));
        }

    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\Project
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
}