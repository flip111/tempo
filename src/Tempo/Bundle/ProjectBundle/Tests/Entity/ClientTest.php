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

use Tempo\ProjectBundle\Entity\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function testInfo()
    {
        $client = new Client();

        $client->setName('Ikimea');
        $this->assertEquals('Ikimea', $client->getName());

        $client->setCreated(new \DateTime('2011-01-01 12:00:00'));
        $this->assertEquals( '2011-01-01 12:00:00', $client->getCreated()->format('Y-m-d H:i:s'));

        $client->setEnabled(true);
        $this->assertEquals(true, $client->isEnabled());

    }

    public function testEmail()
    {
        $client = new Client();
        $client->setContact('test@tempo-project.com');
        $this->assertEquals('test@tempo-project.com', filter_var($client->getContact(), FILTER_VALIDATE_EMAIL));
    }
    public function testFixUrl()
    {
        $client = new Client();
        $client->setWebSite('http://example.com');
        $this->assertEquals('http://example.com', $client->getWebSite());

    }
}
