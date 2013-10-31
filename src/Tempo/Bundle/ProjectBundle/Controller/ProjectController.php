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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Tempo\Bundle\ActivityBundle\Manager\ActivityManager;
use Tempo\Bundle\ProjectBundle\Entity\Project;
use Tempo\Bundle\ProjectBundle\Form\Type\ProjectType;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;

/**
 * Project controller.
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class ProjectController extends Controller
{
    /**
     * @todo generate automatique Breadcrumb
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        /* set breadcrumb */
        $breadcrumb  = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Project');

        $manager = $this->container->get('tempo_project.manager.organization');
        $organizations = $manager->findAllByUser($this->getUser()->getId());

        return $this->render('TempoProjectBundle:Project:dashboard.html.twig', array(
            'organizations' => $organizations
        ));
    }

    /**
     * Lists all organization projects.
     * @param $organization
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function listAction($slug)
    {
        //find info organization
        $manageOrganization = $this->get('tempo_project.manager.organization');
        $organization = $manageOrganization->findOneBySlug($slug);

        if (!$organization) {
            throw new NotFoundHttpException(sprintf("organization with slug '%s' could not be found.", $organization));
        }

        $projects = $organization->getProjects();   //List Project
        $organizations = $manageOrganization->findAll();  // List Organization

        return $this->render('TempoProjectBundle:Project:list.html.twig', array(
            'organization' => $organization,
            'organizations' => $organizations,
            'projects' => $projects
        ));
    }

    /**
     * Finds and displays a Project entity.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function showAction($slug)
    {
        $project  = $this->getProject($slug);
        $csrfToken = $this->get('form.csrf_provider')->generateCsrfToken('delete-project');

        $teamForm = $this->createForm(new TeamType());

        /** @var ActivityManager $activityManager */
        $activityManager = $this->get('tempo.activity.manager');

        return $this->render('TempoProjectBundle:Project:show.html.twig', array(
            'teamForm'      => $teamForm->createView(),
            'project'       => $project,
            'csrfToken'     => $csrfToken,
            'activities'    => $activityManager->getByProject($project)
        ));
    }

    /**
     * Displays a form to create a new Project entity.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction()
    {
        $project = new Project();
        $this->getParent($project);

        $form   = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));

        return $this->render('TempoProjectBundle:Project:new.html.twig',array(
            'entity' => $project,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Project entity.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction()
    {
        $project  = new Project();
        $project->addTeam($this->getUser());
        $this->getParent($project);

        $form  = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));

        if ($form->submit($this->getRequest())->isValid()) {
            $this->getManager()->persistAndFlush($project);
            return $this->redirect($this->generateUrl('project_show', array('slug' => $project->getSlug() )));

        }

        return $this->render('TempoProjectBundle:Project:new.html.twig', array(
            'entity' => $project,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     * @param $slug string
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($slug)
    {
        $project = $this->getProject($slug);
        $editForm = $this->createForm(new ProjectType(), $project);

        return $this->render('TempoProjectBundle:Project:edit.html.twig', array(
            'project'      => $project,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Project entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($slug)
    {

        $request = $this->getRequest();
        $project = $this->getProject($slug);
        $editForm   = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST') && $editForm->submit($request)->isValid()) {
            $this->getManager()->persistAndFlush($project);
            return $this->redirect($this->generateUrl('project_edit', array('slug' => $project->getSlug() )));
        }

        return $this->render('TempoProjectBundle:Project:edit.html.twig', array(
            'project'     =>  $project,
            'edit_form'   =>  $editForm->createView(),
        ));
    }

    /**
     * Deletes a Project entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($slug)
    {
        //check CSRF token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid('delete-organization', $this->getRequest()->get('token'))) {
            throw new AccessDeniedHttpException('Invalid CSRF token.');
        }

        $project = $this->getProject($slug);
        $this->getManager()->removeAndFlush($project);

        return $this->redirect($this->generateUrl('project_home'));
    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\ProjectManager
     * @return mixed
     */
    private function getManager()
    {
        return $this->get('tempo_project.manager.project');
    }

    /**
     * @param $slug
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getProject($primaryKey)
    {
        if (is_string($primaryKey)) {
            $project =  $this->getManager()->findOneBySlug($primaryKey);
        } else {
            $project =  $this->getManager()->find($primaryKey);
        }

        return $project;
    }


    /**
     * @param  \Tempo\Bundle\ProjectBundle\Entity\Project $project
     * @return \Tempo\Bundle\ProjectBundle\Entity\Project
     */
    protected function getParent(Project $project)
    {
        $parent = $this->getRequest()->query->get('parent');

        if (!empty($parent)) {
            $parent = $this->getProject(intval($parent));
            if ($parent) {
                $project->setParent($parent);
            }
        }

        return $project;
    }
}
