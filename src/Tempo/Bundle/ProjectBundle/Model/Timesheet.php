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

use DateTime;

abstract class Timesheet implements TimesheetInterface
{

    protected $id;

    /**
     * @var integer
     */
    protected $project;

    /**
     * @var integer
     */
    protected $membre;

    /**
     * @var \DateTime
     */
    protected $period;

    /**
     * @var \DateTime
     */
    protected $time;

    /**
     * @var integer
     * @param int $created
     */
    protected $created;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var integer
     */
    protected $billable;

    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    public function __toString()
    {
        return $this->time;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * {@inheritdoc}
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * {@inheritdoc}
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set date
     *
     * @param \DateTime $created
     */
    public function setDate(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->created;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set billable
     *
     * @param boolean $billable
     */
    public function setBillable($billable)
    {
        $this->billable = $billable;
    }

    /**
     * Get facturable
     *
     * @return boolean
     */
    public function getBillable()
    {
        return $this->billable;
    }

    /**
     * Set project
     *
     * @param Tempo\Bundle\ProjectBundle\Entity\Project $project
     */
    public function setProject(\Tempo\Bundle\ProjectBundle\Entity\Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return \Tempo\Bundle\ProjectBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user
     *
     * @param integer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

}
