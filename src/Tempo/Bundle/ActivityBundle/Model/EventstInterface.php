<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Model;

use Tempo\Bundle\UserBundle\Entity\User;

interface EventsInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get id.
     *
     * @return string
     */
    public function getTargetType();

    /**
     * Set id.
     *
     * @return string
     */
    public function setTargetType($type);

    /**
     * Get data.
     *
     * @return string
     */
    public function getData();

    /**
     * Set data.
     *
     * @param string $data
     */
    public function setData($data);

    /**
     * get User.
     *
     * @return User $user
     */
    public function getAuthor();

    /**
     * Set User.
     *
     * @param User $user
     */
    public function setAuthor($user);

    /**
     * Creation date.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $created
     */
    public function setCreatedAt(\DateTime $created);
}