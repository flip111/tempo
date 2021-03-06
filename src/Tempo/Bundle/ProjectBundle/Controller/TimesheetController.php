<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Controller;

use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CalendR\Period\Week;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetType;
use Tempo\Bundle\ProjectBundle\Filter\Type\TimesheetFilterType;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetExportType;
use Tempo\Bundle\ProjectBundle\Export\Excel as ExportCVS;

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

        return $this->render('TempoProjectBundle:Timesheet:dashboard.html.twig', $this->filterData($request));
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
            $this->getManager()->save($entity);

            return $this->redirect($this->generateUrl('timesheet'));
        }

        return $this->render('TempoProjectBundle:Timesheet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
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
            $this->getManager()->remove($entity);
        }

        return $this->redirect($this->generateUrl('timesheet'));
    }


    public function exportPDFAction(Request $request)
    {
        $form = $this->createForm(new TimesheetExportType(), array(
            'to' => (new \DateTime())->format('Y-m-d')
        ));

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $list = $this->getManager()->repository->findAll();

            $html = $this->renderView('TempoProjectBundle:Timesheet:export/pdf_tpl.html.twig', array(
                'list'  => $list
            ));

            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="file.pdf"'
                )
            );
        }

        return $this->render('TempoProjectBundle:Timesheet:export/pdf.html.twig', array(
            'form' => $form->createView()
        ));

    }
    public function exportCSVAction(Request $request)
    {
        $form = $this->createForm(new TimesheetExportType(), array(
            'from' => (new \DateTime())->format('Y-m-d')
        ));

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $file = (new ExportCVS($this->filterData($request) ))->save(sys_get_temp_dir() );

            return $this->downloadFile($file);
        }

        return $this->render('TempoProjectBundle:Timesheet:export/excel.html.twig', array(
            'form' => $form->createView()
        ));
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

    private function filterData(Request $request)
    {
        $locale = $this->container->getParameter('locale');
        $weekLang = $this->container->getParameter('tempo_project.week');
        $currentYear = $request->query->get('year', date('Y'));
        $currentWeek = $request->query->get('week', date('W'));

        $week = new \DateTime();
        $week->setISOdate($currentYear, $currentWeek);
        $factoryWeek = new Week($week);

        $weekPagination = array(
            'next' => date("W", strtotime("+1 week", $week->getTimestamp())),
            'current' => $currentWeek ,
            'prev' => date("W", strtotime("-1 week", $week->getTimestamp())),
            'year' => $currentYear
        );

        $filter = $this->createForm(new TimesheetFilterType());

        $data = $this->getManager()->getTimeForPeriod(
            $this->processFilter($filter, $request),
            $factoryWeek,
            $weekLang[$locale],
            $this->getUser()->getId()
        );


        return array(
            'date' => $data['date'],
            'week' => $data['week'],
            'currentWeek' => $week,
            'projects' => $data['projects'],
            'weekPagination' => $weekPagination,
            'filter' => $filter->createView()
        );
    }

    private function processFilter($filterForm, Request $request)
    {
        $filterForm->submit($request);

        if ($filterForm->isValid()) {
            $dataFilter = $filterForm->getData();

            $dataFilter['from'] = new \DateTime($dataFilter['from']);
            $dataFilter['to']  = new \DateTime($dataFilter['to']);

            return $dataFilter;
        }

        return array();
    }

    private function downloadFile($filePath)
    {

        $filename = pathinfo($filePath)['basename'];

        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
}
