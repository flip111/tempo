<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Model;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

interface OrganizationInterface
{

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId();

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated();

    /**
     * @return $enabled
     */
    public function isEnabled();

    /**
     * @return $enabled
     */
    public function isDeletedAt();

    /**
     *  @return $contact
     */
    public function getContact();

    /**
     * @return $users
     */
    public function getUsers();

    /**
     * Get projects
     *
     * @return \Tempo\Bundle\ProjectBundle\Entity\Project
     */
    public function getProjects();

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug);

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $updated);

    /**
     * Set updated
     *
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated);

    /**
     * @param $enabled
     */
    public function setEnabled($enabled);

    /**
     * @param $enabled
     */
    public function setDeleteAt($enabled);

    /**
     *  set contact
     * @param string $contact
     */
    public function setContact($contact);

    /**
     * Set users
     *
     * @param Doctrine_Collection $users
     */
    public function setUsers($users);

    /**
     * Set user
     *
     * @param $user
     */
    public function addUser($user);

    /**
     * Add projects
     *
     * @param \Tempo\Bundle\ProjectBundle\Entity\Project $project
     */
    public function addProject($project);

    /**
     * Set projects
     *
     * @param Doctrine_Collection $projects
     */
    public function setProjects($projects);

    /**
     * @abstract
     * @return Doctrine_Collection
     */
    public function getTeam();

    /**
     * @abstract
     * @param $membre
     * @return mixed
     */
    public function addTeam($user, array $acl = array());

}
