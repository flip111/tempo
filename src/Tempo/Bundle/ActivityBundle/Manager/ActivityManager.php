<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\ActivityBundle\Entity\Activity;

class ActivityManager extends BaseManager
{
    private $userContext;

    public function setSecurityContext($userContext)
    {
        $this->userContext = $userContext->getToken()->getUser();
    }

    public function build($action, $target = '', $actor = null)
    {
        if(null == $actor) {
            $actor = $this->userContext;
        }

        $reflected =  new \ReflectionObject($target);

        $event = new Activity();
        $event
            ->setAuthor($actor)
            ->setAction($action)
            ->setTarget($target)
            ->setTargetType($reflected->getShortName());

        $this->save($event);
    }

    /**
     * @param $type
     * @param SecurityContext $user
     * @return strings
     */
    public function render($type = null, $user = null)
    {
        $fin = $this->repository->findLastActivities($type, $user);

        return $fin;
    }
}