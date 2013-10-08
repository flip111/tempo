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

use Tempo\Bundle\ProjectBundle\Entity\Project;

class LoadProjectData extends AbstractFixture implements FixtureInterface
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $name = str_shuffle('Le Lorem Ipsum');

            $chiffre = str_shuffle('123456789');
            $code = str_shuffle(substr($name, 0, 3).substr($chiffre, 0, 3));

            $project = new Project();
            $project->setName($name);
            $project->setCode($code );
            $project->setSlug(str_replace(' ', '-', $name));
            $project->setDescription('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.');
            $project->setClient( $this->getReference('client'.$i));
            $project->setStatus( rand(1, 3) );
            $project->setAvancement($chiffre[0]);
            $project->setCreated(new \DateTime());
            $project->setUpdated(new \DateTime());
            $project->setIsActive(true);
            $project->setBeginning(new \DateTime());
            $project->setEnding(new \DateTime());

            $manager->persist($project);
            $manager->flush();

            $this->addReference('project'.$i, $project);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
