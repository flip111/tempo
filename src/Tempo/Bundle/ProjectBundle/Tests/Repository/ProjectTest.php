<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ProjectTest extends WebTestCase
{
    protected $entityManager;

    public function setUp()
    {

        $kernel = static::createKernel();
        $kernel->boot();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.entity_manager');
    }



    public function testGetParent()
    {

        // Retrieve "android" project
        $project = $this->entityManager->getRepository('TempoProjectBundle:Project')->findOneBy(array('slug' => 'android'));

        var_dump($project); exit;

        // Test aboutPage
        $this->assertInstanceOf('Tempo\Bundle\ProjectBundle\Entity\Project', $project);
        $this->assertEquals('android', $project->getName());

        // Retrieve parent page
        $parentProject = $project->getParent();
        $this->assertInstanceOf('Tempo\Bundle\ProjectBundle\Entity\Project', $parentProject);
        $this->assertEquals('google', $parentProject->getName());
    }

    /**
     * Test getChildren function
     */
    public function testGetChildren()
    {

        // Retrieve "google" project
        $project = $this->entityManager->getRepository('TempoProjectBundle:Project')->findOneBy(array('slug' => 'google'));

        $this->assertInstanceOf('Tempo\Bundle\ProjectBundle\Entity\Project', $project);
        $this->assertEquals('google', $project->getName());

        // Retrieve children pages
        $childrenProject = $project->getChildren();
        $this->assertInstanceOf('Doctrine\ORM\PersistentCollection', $childrenProject);
    }
}
