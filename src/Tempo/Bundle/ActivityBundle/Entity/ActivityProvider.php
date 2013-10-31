<?php

namespace Tempo\Bundle\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tempo\Bundle\ProjectBundle\Entity\Project;

/**
 * Activity
 *
 * @ORM\Table(name="activity_provider")
 * @ORM\Entity(repositoryClass="Tempo\Bundle\ActivityBundle\Entity\ActivityProviderRepository")
 */
class ActivityProvider
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $provider;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @var Project
     *
     * @ORM\OneToOne(targetEntity="Tempo\Bundle\ProjectBundle\Entity\Project")
     */
    private $project;

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
     * Set provider
     *
     * @param string $provider
     * @return ActivityProvider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ActivityProvider
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set project
     *
     * @param \Tempo\Bundle\ProjectBundle\Entity\Project $project
     * @return ActivityProvider
     */
    public function setProject(\Tempo\Bundle\ProjectBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
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
}
