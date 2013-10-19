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

use Tempo\Bundle\MainBundle\Manager\BaseManager;
use Tempo\Bundle\ProjectBundle\Entity\Project;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class ProjectManager extends BaseManager
{
   protected $em;
   private $class;

    /**
     * @param $event
     * @param $em Doctrine\ORM\EntityManager
     * @param $class
     */
   public function __construct($event, EntityManager $em, $class)
   {
       $this->em = $em;
       $this->class = $class;
       $this->repository = $this->em->getRepository($this->class);
   }

    /**
     * @param $id
     * @return mixed
     */
   public function find($id)
   {
       $project =  $this->getRepository()->find($id);

       if (!$project) {
           throw new NotFoundHttpException('Requested Project does not exist.');
       }

       return $organization;
   }

    /**
     * @param $slug
     * @return mixed
     */
   public function findOneBySlug($slug)
   {
       return $this->getRepository()->findOneBySlug($slug);
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
     * @param $user
     */
    public function findAllByUser($user)
    {
        return $this->getRepository()->findAllByUser($user);
    }

    /**
     * @return mixed
     */
   public function findAll()
   {
        return $this->getRepository()->findAll();
   }


}
