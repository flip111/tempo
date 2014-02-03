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
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

abstract class BaseManager
{
    public $repository;
    protected $em;
    protected $class;

    /**
     * @param $event
     * @param EntityManager $em
     * @param $class
     */
    public function __construct(EntityManager $em, $class)
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
        $entity =  $this->repository->find($id);
        return $this->createNotFoundException($entity);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function findOneBySlug($slug)
    {
        $entity = $this->repository->findOneBySlug($slug);
        return $this->createNotFoundException($entity);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $user
     */
    public function findAllByUser($user)
    {
        return $this->repository->findAllByUser($user);
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
     * @param $entity
     * @throws NotFoundHttpException
     */
    public function createNotFoundException($entity)
    {
        if (!$entity) {
            throw new NotFoundHttpException(sprintf('Unable to find %s entity.', $this->class));
        }

        return $entity;
    }
}