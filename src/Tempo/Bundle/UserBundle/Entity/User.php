<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="membre")
 * @ORM\Entity(repositoryClass="Tempo\Bundle\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string",length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string",length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(name="job_title", type="string",length=255, nullable=true)
     */
    protected $jobTitle;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(name="phone_mobile", type="string",length=255, nullable=true)
     */
    protected $phoneMobile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $avatar;


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
     * @return mixed
     */
    public function getOrganizations()
    {
        return $this->organization;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set job_title
     *
     * @param string $jobTitle
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * Get job_title
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set phone
     *
     * @param string $phone
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
     * Set phone_mobile
     *
     * @param string $phoneMobile
     */
    public function setPhoneMobile($phoneMobile)
    {
        $this->phoneMobile = $phoneMobile;
    }

    /**
     * Get phone_mobile
     *
     * @return string
     */
    public function getPhoneMobile()
    {
        return $this->phoneMobile;
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