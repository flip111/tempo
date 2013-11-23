<?php

namespace Tempo\Bundle\ActivityBundle\Model;

use Tempo\Bundle\ProjectBundle\Model\ProjectInterface;

interface ActivityProviderInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get appId
     *
     * @return integer
     */
    public function getAppId();

    /**
     * Set appId
     *
     * @return integer
     */
    public function setAppId($appId);

    /**
     * Get secret
     *
     * @return integer
     */
    public function getSecret();

    /**
     * Set secret
     *
     * @return integer
     */
    public function setSecret($secret);


    /**
     * Get Token
     *
     * @return integer
     */
    public function getToken();

    /**
     * Set Token
     *
     * @return integer
     */
    public function setToken($secret);

    /**
     * Set provider
     *
     * @param string $provider
     * @return ActivityProvider
     */
    public function setProvider($provider);

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider();

    /**
     * Set url
     *
     * @param string $url
     * @return ActivityProvider
     */
    public function setUrl($url);

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set project
     *
     * @param Project $project
     * @return ActivityProvider
     */
    public function setProject(ProjectInterface $project);

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject();

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return ActivityProvider
     */
    public function setCreated(\Datetime $datetime);

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getCreated();
}
