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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use \DateTime;
use CalendR\Period\Week;
use Tempo\Bundle\ProjectBundle\Entity\Timesheet;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetType;

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
    public function dashboardAction(Request $request)
    {

        $breadcrumb  = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Time Management');
        $breadcrumb->addChild('Dashboard');

        $locale = $this->container->getParameter('locale');
        $weekLang = $this->container->getParameter('tempo_project.week');
        $currentYear = $request->query->get('year', date('Y'));
        $currentWeek = $request->query->get('week', date('W'));

        $week = new DateTime();
        $week->setISOdate($currentYear, $currentWeek);
        $factoryWeek = new Week($week);

        $weekPagination = array(
            'next' => date("W", strtotime("+1 week", $week->getTimestamp())),
            'current' => $currentWeek ,
            'prev' => date("W", strtotime("-1 week", $week->getTimestamp())),
            'year' => $currentYear
        );

        $data = $this->getManager()->getAllCra(
            $factoryWeek,
            $weekLang[$locale],
            $this->getUser()->getId()
        );
        $userList = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findAll();

        return $this->render('TempoProjectBundle:Timesheet:dashboard.html.twig', array(
            'date' => $data['date'],
            'week' => $data['week'],
            'currentWeek' => $week,
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
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $postTimesheet = $request->query->all();
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
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity  = new Timesheet();

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
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getManager()->find($id);

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
        $post = $$this->get('request_stack')->getCurrentRequest()->request->all();
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
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);

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
