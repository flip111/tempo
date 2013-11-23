<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tempo\Bundle\ProjectBundle\Entity\Project;

/**
 * ActivityRepository
 *
 */
class EventsRepository extends EntityRepository
{
    public function findByUser($type, $user)
    {
        $query = $this->createQueryBuilder('e');
        $query->leftJoin('e.author', 'a');

        $query->where('e.targetType = :type');
        $query->setParameter('type', $type);

        if (null !== $user) {
            $query->AndWhere('a.id  = ?1');
            $query->setParameter(1, $user->getId());
        }

        return $query->getQuery()->getResult();
    }
}
