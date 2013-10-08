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

use Tempo\Bundle\ProjectBundle\Entity\Client;

class LoadClientData extends AbstractFixture implements FixtureInterface
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $name = str_shuffle('Le Lorem');

            $client = new Client();
            $client->setName($name);
            $client->setContact('contact@toto.com');
            $client->getWebSite('http://toto.com');
            $client->addEquipe($this->getReference('admin'));

            $manager->persist($client);
            $manager->flush();

            $this->addReference('client'.$i, $client);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
