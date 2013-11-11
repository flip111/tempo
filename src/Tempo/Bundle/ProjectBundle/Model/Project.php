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

use Doctrine\Common\Collections\ArrayCollection;
use Tempo\Bundle\ProjectBundle\Model\OrganizationInterface;
use Tempo\Bundle\ProjectBundle\Model\TimesheetInterface;
use Tempo\Bundle\ActivityBundle\Entity\ActivityProviderInterface;

/**
 * Project Model
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 * @todo: fix php documentor
 */

class Project implements ProjectInterface
{

    const STATUS_CREATED = 10;
    const STATUS_OPENING = 20;
    const STATUS_FINISHED = 50;
    const STATUS_DELETED = -10;


    public static $types = array(0 => 'Default', 1 => 'Agile', 2 => 'Regie', 3 => 'Forfait');

    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Boolean
     */
    protected $isActive;

    /**
     * @var string
     */
    protected $organization;

    /**
     * @var integer
     */
    protected $parent;

    /**
     * @var string
     */
    protected $team;

    /**
     * @var Collection
     */
    protected $children;

    /**
     * @var Collection
     */
    protected $timesheets;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime
     */
    protected $updated;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var \DateTime
     */
    protected $beginning;

    /**
     * @var \DateTime
     */
    protected $ending;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @var integer
     */
    protected $advancement;

    /**
     * @var integer
     */
    protected $priority;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var integer
     */
    protected $budget_estimated;

    /**
     * @var integer
     */
    protected $parents;

    /**
     * @var Collection
     */
    protected $activityProviders;

    public function __construct()
    {
        $this->isActive = true;
        $this->advancement = 0;
        $this->timesheets = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->activityProviders = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set organization
     *
     * @param OrganizationInterface $organization
     */
    public function setOrganization(OrganizationInterface $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return \Tempo\Bundle\ProjectBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
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
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set beginning
     *
     * @param datetime $beginning
     */
    public function setBeginning(\DateTime $beginning)
    {
        $this->beginning = $beginning;
    }

    /**
     * Get beginning
     *
     * @return datetime
     */
    public function getBeginning()
    {
        return $this->beginning;
    }

    /**
     * Set ending
     *
     * @param \DateTime $ending
     */
    public function setEnding(\DateTime $ending)
    {
        $this->ending = $ending;
    }

    /**
     * Get ending
     *
     * @return datetime
     */
    public function getEnding()
    {
        return $this->ending;
    }

    /**
     * Set type
     *
     * @param integer $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set advancement
     *
     * @param integer $avancement
     */
    public function setAdvancement($advancement)
    {
        $this->advancement = $advancement;
    }

    /**
     * Get advancement
     *
     * @return integer
     */
    public function getAdvancement()
    {
        return $this->advancement;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set budget_estimated
     *
     * @param decimal $budgetEstimated
     */
    public function setBudgetEstimated($budgetEstimated)
    {
        $this->budget_estimated = $budgetEstimated;
    }

    /**
     * Get budget_estimated
     *
     * @return decimal
     */
    public function getBudgetEstimated()
    {
        return $this->budget_estimated;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Add timesheet
     *
     * @param TimesheetInterface $timesheet
     */
    public function addTimesheet(TimesheetInterface $timesheet)
    {
        $this->timesheets[] = $timesheet;
    }

    /**
     * @param $timesheets
     */
    public function setTimesheets($timesheets)
    {
        $this->timesheets = $timesheets;
    }

    /**
     * Get timesheet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTimesheets()
    {
        return $this->timesheets;
    }

    public static function getStatusList()
    {
        return array(
            self::STATUS_CREATED => 'created',
            self::STATUS_OPENING => 'open',
            self::STATUS_FINISHED => 'finished',
            self::STATUS_DELETED => 'deleted'
        );
    }

    public function renderStatus()
    {
        $status = self::getStatusList();
        return $status[$this->status];
    }

    /**
     * {@inheritdoc}
     */
    public function getRenderType()
    {
        return self::$types[intval($this->getType())];
    }

    /**
     * {@inheritdoc}
     */
    public function addTeam($user)
    {
        $this->team[] = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * {@inheritdoc}
     */
    public function addChildren(ProjectInterface $children)
    {
        $this->children[] = $children;

        $children->setParent($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(ProjectInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent($level = -1)
    {
        if (-1 === $level) {
            return $this->parent;
        }

        $parents = $this->getParents();

        if ($level < 0) {
            $level = count($parents) + $level;
        }

        return isset($parents[$level]) ? $parents[$level] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getParents()
    {
        if (!$this->parents) {

            $project    = $this;
            $parents = array();

            while ($project->getParent()) {
                $project      = $project->getParent();
                $parents[] = $project;
            }

            $this->setParents(array_reverse($parents));
        }

        return $this->parents;
    }

    /**
     * {@inheritdoc}
     */
    public function addActivityProvider(ActivityProviderInterface $activityProvider)
    {
        $this->activityProviders[] = $activityProvider;

        $activityProvider->setProject($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityProviders()
    {
        return $this->activityProviders;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivityProviders($activityProviders)
    {
        $this->activityProviders = $activityProviders;
    }

}
