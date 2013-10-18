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

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

abstract class BaseManager
{
    protected $repository;


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