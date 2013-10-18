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

use Tempo\Bundle\ProjectBundle\Entity\Project;
use Tempo\Bundle\ProjectBundle\Form\Type\ProjectType;
use Tempo\Bundle\ProjectBundle\Form\Type\EquipeType;

/**
 * Project controller.
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class ProjectController extends Controller
{

    /**
     * Lists all client projects.
     * @param $client
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function listAction($slug)
    {
        //find info client
        $manageClient = $this->get('tempo_project.manager.client');
        $client = $manageClient->findOneBySlug($slug);

        if (!$client) {
            throw new NotFoundHttpException(sprintf("client with slug '%s' could not be found.", $client));
        }

        $projects = $client->getProjects();   //List Project
        $clients = $manageClient->findAll();  // List Client

        return $this->render('TempoProjectBundle:Project:list.html.twig', array(
            'client' => $client,
            'clients' => $clients,
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

        $equipeForm = $this->createForm(new EquipeType());
        $deleteForm = $this->createDeleteForm($project->getId());

        return $this->render('TempoProjectBundle:Project:show.html.twig', array(
            'equipeForm'      => $equipeForm->createView(),
            'project'      => $project,
            'csrfToken'      => $csrfToken,
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
        $project->addEquipe($this->getUser());
        $this->getParent($project);

        $form   = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));
        $form->submit( $this->getRequest());

        if ($form->isValid()) {
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
        $project = $this->getProject($slug);
        $editForm   = $this->createForm(new ProjectType(), $project);

        $editForm->submit($this->getRequest());

        if ($editForm->isValid()) {

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
     * return Tempo\Bundle\ProjectBundle\Manager\Project
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
