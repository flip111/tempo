<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Tempo\Bundle\ProjectBundle\Entity\ProjectType;

class LoadProjectData extends AbstractFixture implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $types = array(
            'Scrum',
            'Xp',
            'Kanban'
        );

        foreach($types as $type)
        {
            $projectType = new ProjectType();
            $projectType->setName($type);
            $manager->persist($projectType);
            $manager->flush();
        }
    }
}
