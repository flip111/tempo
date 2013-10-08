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

use Tempo\ProjectBundle\Entity\Project as Project;
use Gedmo\Sluggable\Util\Urlizer;

class PageTest extends \PHPUnit_Framework_TestCase
{
    public function testFixUrl()
    {
        $entityManager = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);

        $project = new Project();
        $project->setName('Super project ninja ?');
        $project->setSlug(Urlizer::transliterate('Super project ninja ?'));

        $entityManager->flush($project);

        $this->assertEquals('super-project-ninja', Urlizer::transliterate($project->getName()));
    }
}
