<?php

namespace Tempo\Bundle\ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends Controller
{
    public function providerAction(Request $request, $providerName)
    {
        /** @var $manager \Tempo\Bundle\ActivityBundle\Manager\ActivityManager */
        $manager = $this->get('tempo.activity.manager');

        $manager->add($providerName, $request);
    }
}
