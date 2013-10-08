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
use Tempo\Bundle\ProjectBundle\Form\ProjectType;
use Tempo\Bundle\ProjectBundle\Form\EquipeType;

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
    public function listAction($client)
    {
        $em = $this->getDoctrine()->getManager();
        $slug = $client;

        //find info client
        $client = $em->getRepository('TempoProjectBundle:Client')->findOneBySlug($slug);

        if (!$client) {
            throw new NotFoundHttpException(sprintf("client with slug '%s' could not be found.", $client));
        }

        $projects = $client->getProjects();   //List Project
        $clients = $em->getRepository('TempoProjectBundle:Client')->findAll();  // List Client

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
        $project = $this->getDoctrine()->getManager()
            ->getRepository('TempoProjectBundle:Project')->findOneBySlug($slug);

        if (!$project) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $equipeForm = $this->createForm(new EquipeType());
        $deleteForm = $this->createDeleteForm($project->getId());

        return $this->render('TempoProjectBundle:Project:show.html.twig', array(
            'equipeForm'      => $equipeForm->createView(),
            'project'      => $project,
            'delete_form' => $deleteForm->createView()
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

        $this->getParent($project);

        $project->addEquipe($this->getUser());
        $request = $this->getRequest();
        $form   = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

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
        $em = $this->getDoctrine()->getManager();

        $project = $em->getRepository('TempoProjectBundle:Project')->findOneBySlug($slug);

        if (!$project) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $editForm = $this->createForm(new ProjectType(), $project);
        $deleteForm = $this->createDeleteForm($project->getId());

        return $this->render('TempoProjectBundle:Project:edit.html.twig', array(
            'project'      => $project,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Project entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TempoProjectBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $editForm   = $this->createForm(new ProjectType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('project_edit', array('slug' => $entity->getSlug()  )));
        }

        return $this->render('TempoProjectBundle:Project:edit.html.twig', array(
            'project'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Project entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TempoProjectBundle:Project')->find($id);
            $em->getRepository('TempoProjectBundle:Project')->findBy(array('name' => 'slug'));

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Project entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('project_home'));
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * @param  \Tempo\Bundle\ProjectBundle\Entity\Project $project
     * @return \Tempo\Bundle\ProjectBundle\Entity\Project
     */
    protected function getParent(Project $project)
    {
        $em = $this->getDoctrine()->getManager();
        $parent = $this->getRequest()->query->get('parent');

        if (!empty($parent)) {
            $parent = $em->getRepository('TempoProjectBundle:Project')->find($parent);
            if ($parent) {
                $project->setParent($parent);
            }
        }

        return $project;
    }
}
