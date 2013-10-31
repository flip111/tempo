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

class ActivityController extends Controller
{
    public function providerAction(Request $request, $providerName)
    {
        /** @var $manager \Tempo\Bundle\ActivityBundle\Manager\ActivityManager */
        $manager = $this->get('tempo.activity.manager');

        $manager->add($providerName, $request);
    }
}
