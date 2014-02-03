<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\EventListener;

use Tempo\Bundle\ProjectBundle\Event\ProjectEvent;
use Tempo\Bundle\MainBundle\Manager\RoomManager;

class ProjectListener
{
    private $roomManager;

    public function __construct(RoomManager $roomManager)
    {
        $this->roomManager = $roomManager;
    }

    public function createProject(ProjectEvent $event)
    {
        $project = $event->getProject();

        //create room
        $this->roomManager->create($project->getName(), $project);
    }
}