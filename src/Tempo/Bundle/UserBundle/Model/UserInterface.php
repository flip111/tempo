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

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use Sylius\Bundle\ResourceBundle\Model\TimestampableInterface;


interface UserInterface extends BaseUserInterface, TimestampableInterface
{
    /**
     * Get first name
     */
    public function getFirstName();

    /**
     * Set first name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * Get last name
     */
    public function getLastName();

    /**
     * Set last name
     *
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany();

    /**
     * Set currency
     *
     * @param string $company
     */
    public function setCompany($company);

    /**
     * Get Job tile.
     *
     */
    public function getJobTitle();

    /*
     * Set job title.
     *
     * @param string $job
     */
    public function setJobTitle($job);

    /**
     * Get Job tile.
     *
     */
    public function getPhone();

    /*
    * Set phone
    *
    * @param string $phone
    */
    public function setPhone($phone);

    /**
     * Get mobile phone.
     *
     */
    public function getMobilePhone();

    /*
     * Set mobile phone
     *
     * @param string $phone
     */
    public function setMobilePhone($phone);

    /**
     * get username Skype
     */
    public function getSkype();

    /**
     * set username Skype
     *
     * @param string $skype
     */
    public function setSkype($skype);

    /**
     * get username Linkedin
     *
     */
    public function getLinkedin();

    /**
     * set username Linkedin
     *
     * @param string $linkedin
     */
    public function setLinkedin($linkedin);

    /**
     * get username Twitter
     *
     */
    public function getTwitter();

    /**
     * set username Twitter
     *
     * @param string $twitter
     */
    public function setTwitter($twitter);

    /**
     * get username Viadeo
     *
     */
    public function getViadeo();

    /**
     * set username Viadeo
     *
     * @param string $viadeo
     */
    public function setViadeo($viadeo);

}
