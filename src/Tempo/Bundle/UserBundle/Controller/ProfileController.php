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
use Tempo\Bundle\UserBundle\Form\Type\AvatarType;

use Tempo\Bundle\UserBundle\Form\Handler\AvatarHandler;

class ProfileController extends Controller
{
    /**
     * @param $slug
     * @return mixed
     */
    public function editAction()
    {
        $form = $this->createForm(new ProfileType(), $this->getEditableUser());
        return $this->render( 'TempoUserBundle:Profile:edit.html.twig', array('form' => $form->createView()) );
    }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function pictureAction($id = null)
    {
        $request = $this->getRequest();
        $user = $this->getEditableUser($id);
        $own = $user->getId() == $this->getUser()->getId();

        $form = $this->createForm(new AvatarType());

        $handler = new AvatarHandler($request, $form, $this->getDoctrine(), $this->get('liip_imagine'));
        $handler->setPath($this->get('kernel')->getRootDir().'/../web/');

        //@todo : Urgent refactor
        if (($retval = $handler->process($user)) !== false) {
            if (AvatarHandler::INTERNAL_ERROR === $retval) {

                $this->get('session')->getFlashBag()->add('error', 'Une erreur interne est survenue, veuillez réessayer.');
                return new  RedirectResponse($this->generateUrl('user_profile_avatar', array('id' => $own ? null : $user->getId())));
            } elseif (AvatarHandler::WRONG_FORMAT === $retval) {

                $this->get('session')->getFlashBag()->add('error', 'Le format de votre fichier est invalide.');
                return new  RedirectResponse($this->generateUrl('user_profile_avatar', array('id' => $own ? null : $user->getId())));
            } elseif (AvatarHandler::AVATAR_DELETED === $retval) {
                if ($own) {
                    $this->get('session')->getFlashBag()->add('notice', 'Votre avatar a bien été supprimé.');
                    return new  RedirectResponse($this->generateUrl('user_profile_avatar'));
                }

                $this->get('session')->getFlashBag()->add('notice', 'L\'avatar a bien été supprimé.');
                return new  RedirectResponse($this->generateUrl('user_profile_avatar', array(
                    'id' => $user->getId(),
                    'slug' => $user->getSlug(),
                )));
            }

            if ($own) {
                $this->get('session')->getFlashBag()->add('notice', 'Votre avatar a bien été modifié.');
                return new  RedirectResponse($this->generateUrl('user_profile_avatar'));
            }

            $this->get('session')->getFlashBag()->add('notice', 'L\'avatar a bien été modifié');
            return new  RedirectResponse($this->generateUrl('user_profile_avatar', array(
                'id' => $user->getId(),
                'slug' => $user->getSlug(),
            )));

        }

        return $this->render('TempoUserBundle:Profile:avatar.html.twig', array(
            'user' => $user,
            'own' => $own,
            'form' => $form->createView(),
        ));
    }

    public function updateAction()
    {
        $user = $this->getEditableUser();
        $form = $this->createForm(new ProfileType(), $user);
        $request = $this->getRequest();


        if ($request->getMethod() == "POST") {
            $form->submit($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
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
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('TempoUserBundle:Profile:show.html.twig', array('profile' => $profile));
    }


    public function settingAction()
    {
        $profile = $this->getEditableUser();

        $form = $this->createForm(new SettingsType());
        return $this->render('TempoUserBundle:Profile:settings.html.twig', array(
            'profile' => $profile,
            'form' => $form->createView()
        ));
    }

    public function getEditableUser()
    {
        return $this->getUser();
    }
}