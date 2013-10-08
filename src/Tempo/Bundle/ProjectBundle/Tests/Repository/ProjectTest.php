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

use Tempo\ProjectBundle\Tests\Repository\Test as TestCase;
use Tempo\ProjectBundle\Entity\Project;

class ProjectTest extends TestCase
{
    public function testGetParent()
    {
        // Retrieve entity manager
        $em = $this->getEntityManager();

        // Retrieve "android" project
        $project = $em->getRepository('TempoProjectBundle:Project')->findOneBy(array('slug' => 'android'));

        // Test aboutPage
        $this->assertInstanceOf('Tempo\ProjectBundle\Entity\Project', $project);
        $this->assertEquals('android', $project->getName());

        // Retrieve parent page
        $parentProject = $project->getParent();
        $this->assertInstanceOf('Tempo\ProjectBundle\Entity\Project', $parentProject);
        $this->assertEquals('google', $parentProject->getName());
    }

    /**
     * Test getChildren function
     */
    public function testGetChildren()
    {
        // Retrieve entity manager
        $em = $this->getEntityManager();

        // Retrieve "google" project
        $project = $em->getRepository('TempoProjectBundle:Project')->findOneBy(array('slug' => 'google'));

        $this->assertInstanceOf('Tempo\ProjectBundle\Entity\Project', $project);
        $this->assertEquals('google', $project->getName());

        // Retrieve children pages
        $childrenProject = $project->getChildren();
        $this->assertInstanceOf('Doctrine\ORM\PersistentCollection', $childrenProject);
    }
}
