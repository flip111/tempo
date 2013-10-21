<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

abstract class BaseManager
{
    protected $repository;
    protected $em;
    protected $class;

    /**
     * @param $event
     * @param EntityManager $em
     * @param $class
     */
    public function __construct(ContainerAwareEventDispatcher $event, EntityManager $em, $class)
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

       $entity =  $this->getRepository()->find($id);

       if (!$entity) {
           throw new NotFoundHttpException(sprintf('Unable to find %d entity.', $this->class));
       }

       return $entity;

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
     * @return mixed
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param $user
     */
    public function findAllByUser($user)
    {
        return $this->getRepository()->findAllByUser($user);
    }

    /**
     * persist and flush
     * @param $entity
     */
    public function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * remove and flush
     * @param $entity
     */
    public function removeAndFlush($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }
}