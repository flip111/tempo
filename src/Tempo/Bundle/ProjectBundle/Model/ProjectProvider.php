<?php

namespace Tempo\Bundle\ProjectBundle\Model;

use Tempo\Bundle\ProjectBundle\Model\ProjectInterface;

class ProjectProvider implements ProjectProviderInterface
{
    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $appId;

    /**
     * @var string
     *
     */
    protected $secret;

    /**
     * @var string
     *
     */
    protected $token;

    /**
     * @var string
     *
     */
    protected $provider;

    /**
     * @var \DateTime
     *
     */
    protected $created;

    /**
     * @var string
     *
     */
    protected $url;

    /**
     * @var Project
     *
     */
    protected $project;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppId($appId)
    {
        return $this->appId = $appId ;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }
}
