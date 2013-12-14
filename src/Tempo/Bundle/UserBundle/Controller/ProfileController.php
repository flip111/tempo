<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Tempo\Bundle\UserBundle\Form\Type\SettingsType;
use Tempo\Bundle\UserBundle\Form\Type\ProfileType;

class ProfileController extends Controller
{
    /**
     * @param $slug
     * @return mixed
     */
    public function editAction()
    {
        $form = $this->createForm(new ProfileType(), $this->getUser());
        return $this->render( 'TempoUserBundle:Profile:edit.html.twig', array('form' => $form->createView()) );
    }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function pictureAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->get('tempo_user.profile.form.avatar.factory');
        $handler = $this->get('tempo_user.profile.handler.avatar');

        //@todo : Urgent refactor
        if (($retval = $handler->process($user)) !== false) {

            if ($handler::INTERNAL_ERROR === $retval) {
                $this->get('session')->getFlashBag()->add('error', $this->translate('avatar.failed_internal_error'));
            } elseif ($handler::WRONG_FORMAT === $retval) {
                $request->getSession()->getFlashBag()->add('error', $this->translate('avatar.failed_valid_file'));
            } elseif ($handler::AVATAR_DELETED === $retval) {
                $this->get('session')->getFlashBag()->add('notice', $this->translate('avatar.success_delete'));
            } else {
                $request->getSession()->getFlashBag()->add('success', $this->translate('avatar.success_edit'));
            }
        }

        return $this->render('TempoUserBundle:Profile:avatar.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function updateAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new ProfileType(), $user);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();
        }
        return $this->render( 'TempoUserBundle:Profile:edit.html.twig',  array('form' => $form->createView()));

    }

    /**
     * @param $slug
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $profile = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findOneBy(array('usernameCanonical' => $slug));

        if(!$profile) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $organizations = $this->get('tempo_project.manager.organization')->findAllByUser($profile->getId());

        return $this->render('TempoUserBundle:Profile:show.html.twig', array(
            'profile' => $profile,
            'organizations' => $organizations
        ));
    }

    /**
     * @return Response
     */
    public function settingAction()
    {
        $profile = $this->getUser();

        $form = $this->createForm(new SettingsType());
        return $this->render('TempoUserBundle:Profile:settings.html.twig', array(
            'profile' => $profile,
            'form' => $form->createView()
        ));
    }

    /**
     * Get translator.
     *
     * @return TranslatorInterface
     */
    private function getTranslator()
    {
        return $this->get('translator');
    }

    private function translate($trans)
    {
        $this->getTranslator()->trans($trans, array(), 'TempoUser');
    }
}