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
class ActivityProviderRepository extends EntityRepository
{
    public function findByProject(Project $project)
    {
        $query  = $this->queryLastActivities(null);
        $query->Andwhere('e.project = :project');
        $query->setParameter('project', $project);

        return $query->getResult();
    }

    public function findAllWithProvider($type)
    {
        $query  = $this->queryLastActivities($type);

        return $query->getResult();
    }

    /**
     * @param $type
     * @return \Doctrine\ORM\Query
     */
    public function queryLastActivities($type)
    {
        $query = $this->createQueryBuilder('a');
        $query->leftJoin('a.author', 'a');

        if (null !== $type) {
            $query->where('e.provider = :type');
            $query->setParameter('type', $type);
        }

        return $query->getQuery();
    }
}
