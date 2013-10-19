<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\ProjectBundle\Entity\Organization;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationManager extends BaseManager
{

    /**
     * @param $id
     * @return mixed
     */
   public function find($id)
   {
       $organization =  $this->getRepository()->find($id);

       if (!$organization) {
           throw new NotFoundHttpException('Unable to find Organization entity.');
       }

       return $organization;
   }

    /**
     * @param $username
     * @return string
     */
   public function findOneByUsername($username)
   {
       return $this->getRepository()->findOneByUsername($username);
   }

    /**
     * return list projects organization
     * @param $id
     * @return array
     */
   public function getStatusProjects($id)
   {
       $counter = $this->getRepository()->countProject($id);

       return array(
           'close' => $counter['prj_close'],
           'open'  => $counter['prj_open']
       );
   }

    /**
     * @param $user
     */
    public function findAllByUser($user)
    {
        return $this->getRepository()->findAllByUser($user);
    }
}
