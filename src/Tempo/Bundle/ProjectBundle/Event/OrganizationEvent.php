<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Event;

use Tempo\Bundle\ProjectBundle\Model\OrganizationInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;


class OrganizationEvent extends Event
{
    private $request;
    private $organization;

    /**
     * @param OrganizationInterface $organization
     * @param Request $request
     */
    public function __construct(OrganizationInterface $organization, Request $request)
    {
        $this->organization = $organization;
        $this->request = $request;
    }

    /**
     * @return OrganizationInterface
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}