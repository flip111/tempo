<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Form\Type\ProviderFormType;


class ProviderController extends Controller
{
    public function listAction($slug)
    {
        return $this->render('TempoActivityBundle:Provider:list.html.twig', array(
            'slug' => $slug,
            'providers' => $this->get('tempo.activity.provider_registry')->getProviders()
        ));
    }

    public function updateAction(Request $request, $slug, $provider)
    {
        $projectProvider = $this->getDoctrine()
            ->getRepository('TempoProjectBundle:ProjectProvider')
                ->findOneByName($provider);

        $form = $this->createForm(new ProviderFormType(), $projectProvider);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $this->getDoctrine()->getManager()->persist($projectProvider);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('project_show', array(
                'slug' => $slug,
            )));
        }

        return $this->render('TempoActivityBundle:Provider:update.html.twig', array(
            'form' => $form->createView(),
            'slug' => $slug,
            'provider' => $provider
        ));
    }
}
