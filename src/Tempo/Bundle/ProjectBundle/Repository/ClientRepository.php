<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClientRepository extends EntityRepository
{
    public function findClientByUser($user)
    {
        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.equipe', 'pu');

        if (null !== $user) {
            $query->where('pu.id  = ?1');
            $query->setParameter(1, $user);
        }

        return $query;
    }

    /**
     * @param $user
     * @return array
     */
    public function findAllByUser($user)
    {
        $query = $this->findClientByUser($user);

        return $query->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function countProject($id)
    {
        $stmt = $this->getEntityManager()
        ->getConnection()
        ->prepare('SELECT (SELECT COUNT(p1.id) FROM project p1 WHERE p1.client_id = :client AND is_active = 1) as prj_close, (SELECT COUNT(id) FROM project p2 WHERE p2.client_id = :client AND is_active = 0) as prj_open');
        $stmt->bindParam('client', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $counter =  $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $counter[0];
    }
}
