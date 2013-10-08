<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
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

interface TimesheetInterface
{

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param \DateTime $time
     */
    public function getPeriod();

    /**
     * @return \DateTime
     */
    public function getTime();

    /**
     * @param date $date
     */
    public function setCreated($date);

    /**
     * Get date
     *
     * @return date
     */
    public function getDate();

    /**
     * @param \DateTime $time
     */
    public function setTime($time);

    /**
     * @param \DateTime $time
     */
    public function setPeriod($time);

    /**
     * @param text $description
     */
    public function setDescription($description);

    /**
     * @return text
     */
    public function getDescription();

    /**
     * @param boolean $billable
     */
    public function setBillable($facturable);

    /**
     * @return boolean
     */
    public function getBillable();

    /**
     * @return Tempo\ProjectBundle\Entity\Projet
     */
    public function getProject();

    /**
     * @param integer $user
     */
    public function setUser($user);

    /**
     * @return integer
     */
    public function getUser();

    /**
     * @param integer $project
     */
    public function setProject(\Tempo\Bundle\ProjectBundle\Entity\Project $project);

}
