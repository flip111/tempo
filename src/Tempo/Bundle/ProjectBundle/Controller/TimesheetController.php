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

use Tempo\Bundle\ProjectBundle\Entity\Timesheet;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetType;

use Symfony\Component\HttpFoundation\Request;
use Locale;

/**
 * Timesheet controller.
 *
 */
class TimesheetController extends Controller
{

    /**
     * Lists all Timesheet entities.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        $locale = $this->container->getParameter('locale');
        $user = $this->getUser();
        $weekLang = $this->container->getParameter('tempo_project.week');
        $data = $this->container->get('tempo_project.manager.timesheet')->getAllCra($weekLang[$locale], $user->getId());
        $timesheet = new Timesheet();
        $timesheet->setUser($user->getId());
        $form = $this->createForm(new TimesheetType());
        $userList = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findAll();

        return $this->render('TempoProjectBundle:Timesheet:index.html.twig', array(
            'date' => $data['date'],
            'week' => $data['week'],
            'projects' => $data['projects'],
            'form' => $form->createView(),
            'users' => $userList
        ));
    }

    /**
     * Displays a form to create a new Timesheet entity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postTimesheet = $this->getRequest()->query->all();
        $project = $em->getRepository('TempoProjectBundle:Project')->find($postTimesheet['projectid']);

        $entity = new Timesheet();
        $entity->setCreated(new \DateTime($postTimesheet['date']));
        $entity->setProject($project);
        $entity->setUser($this->getUser()->getId());

        $form  = $this->createForm(new TimesheetType(), $entity);

        return $this->render('TempoProjectBundle:Timesheet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Timesheet entity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction()
    {

        $em = $this->getDoctrine()->getManager();

        $entity  = new Timesheet();
        $request = $this->getRequest();

        //Update request
        $postTimesheet = $request->request->get('timesheet');

        $entity->setProjectId($postTimesheet['project_id']);
        $entity->setUser($this->getUser());

        $form    = $this->createForm(new TimesheetType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

        }

        return $this->render('TempoProjectBundle:Timesheet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Timesheet entity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TempoProjectBundle:Timesheet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Timesheet entity.');
        }

        $editForm = $this->createForm(new TimesheetType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TempoProjectBundle:Timesheet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Timesheet entity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TempoProjectBundle:Timesheet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Timesheet entity.');
        }

        $editForm   = $this->createForm(new TimesheetType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('timesheet_edit', array('id' => $id)));
        }

        return $this->render('TempoProjectBundle:Timesheet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function postDataAction()
    {
        $post = $this->getRequest()->request->all();
        $post = $post['timesheet'];

        $time = new Timesheet();
        $time->setTime($post['time']);
        $time->setPeriod(new \Datetime($post['date']));
        $time->setDate(new \Datetime());
        $time->setProject($this->getDoctrine()->getRepository('TempoProjectBundle:Project')->find($post['project']));
        $time->setDescription($post['description']);
        $time->setUser($this->getUser());

        $this->getDoctrine()->getManager()->persist($time);
        $this->getDoctrine()->getManager()->flush();

        return new \Symfony\Component\HttpFoundation\Response('done');
    }

        /**
     * Deletes a Timesheet entity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TempoProjectBundle:Timesheet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Timesheet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('timesheet'));
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
}
