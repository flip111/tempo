<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\UserBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;


class User extends BaseUser implements UserInterface
{
    protected $id;
    protected $createdAt;
    protected $firstName;
    protected $lastName;
    protected $gender;
    protected $company;
    protected $jobTitle;
    protected $phone;
    protected $mobilePhone;
    protected $avatar;
    protected $skype;
    protected $linkedin;
    protected $twitter;
    protected $viadeo;
    protected $organization;

    public function __construct()
    {
        parent::__construct();
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
     * Alias for parent::getUsernameCanonical()
     * @param $slug
     * @return string
     */
    public function getSlug()
    {
        return $this->getUsernameCanonical();
    }

    /**
     * {@inheritdoc}
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganizations()
    {
        return $this->organization;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        parent::setEmail($email);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical($emailCanonical)
    {
        parent::setEmailCanonical($emailCanonical);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * {@inheritdoc}
     */
    public function setMobilePhone($phone)
    {
        $this->mobilePhone = $phone;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

   /**
    * {@inheritdoc}
    */
    public function setSkype($skype)
    {
        $this->skype = $skype;
    }

    /**
     * {@inheritdoc}
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * {@inheritdoc}
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * {@inheritdoc}
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

   /**
    * {@inheritdoc}
    */
    public function setViadeo($viadeo)
    {
        $this->viadeo = $viadeo;
    }

    /**
     * {@inheritdoc}
     */
    public function getViadeo()
    {
        return $this->viadeo;
    }

    public function hasAvatar()
    {
        return $this->hasLocalAvatar() || $this->hasGravatar();
    }

    public function hasLocalAvatar()
    {
        return (boolean)$this->avatar;
    }

    public function hasGravatar()
    {
        return (boolean)@fopen($this->getGravatarUrl() . '?d=404', 'r');
    }


    public function getAvatar($size = 80, $default = 'mm')
    {
        if ($this->avatar) {
            return '/uploads/avatars/' . $this->avatar;
        }

        return $this->getGravatarUrl() . '?s=' . $size . '&d=' . $default;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    protected function getGravatarUrl()
    {
        return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

    public function getGender()
    {
        return $this->gender;
    }
}