<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Manager;

use Tempo\Bundle\MainBundle\Entity\Room;
use Tempo\Bundle\CoreBundle\Manager\BaseManager;

/**
 *
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class RoomManager extends BaseManager
{
    public function create($name, $project)
    {
        $room = new Room();
        $room->setName($name);
        $room->setProject($project);

        $this->save($room);
    }

    public function findRoomWithProject($project)
    {
        return $this->repository->findRoomWithProject($project);
    }
}