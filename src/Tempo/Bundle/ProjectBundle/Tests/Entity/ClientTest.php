<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tests\Entity;

use Tempo\Bundle\ProjectBundle\Entity\Organization;

class OrganizationTest extends \PHPUnit_Framework_TestCase
{

    public function testInfo()
    {
        $organization = new Organization();

        $organization->setName('Ikimea');
        $this->assertEquals('Ikimea', $organization->getName());

        $organization->setCreated(new \DateTime('2011-01-01 12:00:00'));
        $this->assertEquals( '2011-01-01 12:00:00', $organization->getCreated()->format('Y-m-d H:i:s'));

        $organization->setEnabled(true);
        $this->assertEquals(true, $organization->isEnabled());

    }

    public function testEmail()
    {
        $organization = new Organization();
        $organization->setContact('test@tempo-project.com');
        $this->assertEquals('test@tempo-project.com', filter_var($organization->getContact(), FILTER_VALIDATE_EMAIL));
    }
    public function testFixUrl()
    {
        $organization = new Organization();
        $organization->setWebSite('http://example.com');
        $this->assertEquals('http://example.com', $organization->getWebSite());

    }
}
