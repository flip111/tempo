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

use \DateTime;
use CalendR\Period\Week;
use Tempo\Bundle\ProjectBundle\Entity\Timesheet;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        $breadcrumb  = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Time Management');
        $breadcrumb->addChild('Dashboard');

        $locale = $this->container->getParameter('locale');
        $weekLang = $this->container->getParameter('tempo_project.week');
        $currentYear = $this->getRequest()->query->get('year', date('Y'));
        $currentWeek = $this->getRequest()->query->get('week', date('W'));

        $weekPagination = array(
            'next' => date("W", strtotime("+1 week")),
            'current' => $currentWeek ,
            'prev' => date("W", strtotime("-1 week")),
            'year' => $currentYear
        );

        $currentWeek = new DateTime();
        $currentWeek->setISOdate($currentYear, $weekPagination['current']);
        $factoryWeek = new Week($currentWeek);


        $data = $this->getManager()->getAllCra(
            $factoryWeek,
            $weekLang[$locale],
            $this->getUser()->getId()
        );
        $userList = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findAll();

        return $this->render('TempoProjectBundle:Timesheet:index.html.twig', array(
            'date' => $data['date'],
            'week' => $data['week'],
            'projects' => $data['projects'],
            'users' => $userList,
            'weekPagination' => $weekPagination
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

        $form = $this->createForm(new TimesheetType(), $entity);
        $form->submit($request);

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
     * Displays a form to edit an existing Timesheet.
     *
     */
    public function editAction($id)
    {

        $entity = $this->getManager()->find($id);

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
        $entity = $this->getManager()->find($id);
        $request = $this->getRequest();

        $editForm   = $this->createForm(new TimesheetType(), $entity);

        if ($request->isMethod('POST') && $editForm->submit($request)->isValid()) {
            $this->getManager()->persistAndFlush($entity);
            return $this->redirect($this->generateUrl('timesheet'));
        }

        return $this->render('TempoProjectBundle:Timesheet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function postDataAction()
    {
        $post = $this->getRequest()->request->all();
        $post = $post['timesheet'];

        $time = new Timesheet();
        $time->setTime($post['time']);
        $time->setPeriod(new \Datetime($post['date']));
        $time->setProject($this->geManager()->find($post['project']));
        $time->setDescription($post['description']);
        $time->setUser($this->getUser());

        $this->getManager()->persistAndFlush($time);

        return new Response('done');
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

        if ($form->submit($request)->isValid()) {
            $entity = $this->getManager()->find($id);
            $this->getManager()->removeAndFlush($entity);
        }

        return $this->redirect($this->generateUrl('timesheet'));
    }

    private function getManager()
    {
        return $this->get('tempo_project.manager.timesheet');
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
