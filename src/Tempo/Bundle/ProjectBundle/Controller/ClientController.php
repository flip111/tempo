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

use Tempo\Bundle\ProjectBundle\Entity\Client;
use Tempo\Bundle\ProjectBundle\Form\Type\ClientType;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class ClientController extends Controller
{
    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $client = $this->findClient($slug);
        $csrfToken = $this->get('form.csrf_provider')->generateCsrfToken('delete-organization');

        $manager = $this->container->get('tempo_project.manager.client');
        $counter = $manager->getStatusProjects($client->getId());

        $breadcrumb = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Client');
        $breadcrumb->addChild($client->getName());

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Client:show.html.twig', array(
            'client' => $client,
            'counter' => $counter,
            'projects' => $client->getProjects(),
            'teamForm' => $teamForm,
            'csrfToken' => $csrfToken
        ));
    }

    /**
     * Create new client
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $form = $this->createForm(new ClientType(), new Client(), array('is_new' => true));

        return $this->render('TempoProjectBundle:Client:new.html.twig', array(
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
        $client = $this->findClient($slug);

        $breadcrumb = $this->get('tempo_main.breadcrumb');
        $breadcrumb->addChild('Client');
        $breadcrumb->addChild($client->getName());
        $breadcrumb->addChild('Editer le client');

        $editForm = $this->createForm(new ClientType(), $client);

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Client:edit.html.twig', array(
            'client' => $client,
            'form' => $editForm->createView(),
            'teamForm' => $teamForm->createView(),
        ));
    }

    /**
     * Edits an existing Client entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction($id)
    {
        $manager = $this->get('tempo_project.manager.client');
        $request = $this->getRequest();

        $client = $manager->find($id);

        $editForm = $this->createForm(new ClientType(), $client);

        if ($request->getMethod() == "POST") {

            $editForm->submit($request);

            if ($editForm->isValid()) {

                $manager->persistAndFlush($client);

                $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('Le client a bien été mis à jour avec succès !'));

                return $this->redirect($this->generateUrl('client_show', array('slug' => $client->getSlug()  )));
            }
        }

        return $this->render('TempoProjectBundle:Client:edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Create a client
     * @return array
     */
    public function createAction()
    {
        $request = $this->getRequest();

        $client = new Client();
        $client->addTeam($this->getUser());

        $form = $this->createForm(new ClientForm(), $client);
        $form->setData($client);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $em = $this->container->get('doctrine.orm.entity_manager');
                $em->persist($client);
                $em->flush();

                $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('Client ajouté avec succès !'));

                return $this->redirect($this->generateUrl('client_edit', array('slug' => $client->getSlug() )));
            }

            return array(
                'entity' => $client,
                'form'   => $form->createView()
            );
        }
    }

    /**
     * Delete a client
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($slug)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $client = $this->findClient($slug);

        //check CSRF token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid('delete-organization', $request->get('token'))) {
            throw new AccessDeniedHttpException('Invalid CSRF token.');
        }

        try {

            $em->remove($client);
            $em->flush();
            $this->get('session')->getFlashBag()->set('notice', $this->get('translator')->trans('Client supprimé avec succès !'));

            return $this->redirect($this->generateUrl('project_home'));

        } catch (\Exception $e) {

            $this->get('session')->getFlashBag()->set('error', $this->get('translator')->trans('Impossible de supprimer le client'));

            return $this->redirect($this->generateUrl('client_show', array('slug' => $client->getSlug() )));
        }

    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\Project
     * @return mixed
     */
    private function getManager()
    {
        return $this->get('tempo_project.manager.client');
    }

    /**
     * @param $slug
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function findClient($slug)
    {
        return $this->getManager()->findOneBySlug($slug);
    }
}
