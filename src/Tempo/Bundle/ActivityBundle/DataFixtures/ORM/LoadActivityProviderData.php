<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;


use Tempo\Bundle\ActivityBundle\Entity\ActivityProvider;

class LoadActivityProviderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<5; $i++) {

            $activity = new ActivityProvider();
            $activity->setProvider($this->getReference('project_privider_'.$i));
            $activity->setMessage('tempo.activity.provider.github.commit');
            $activity->setParameters(unserialize('a:2:{s:10:"repository";O:8:"stdClass":21:{s:2:"id";i:4233459;s:4:"name";s:5:"tempo";s:3:"url";s:38:"https://github.com/tempo-project/tempo";s:11:"description";s:44:"Tempo - Symfony2 Project Management Software";s:8:"homepage";s:24:"http:///tempo.ikimea.com";s:8:"watchers";i:3;s:10:"stargazers";i:3;s:5:"forks";i:0;s:4:"fork";b:0;s:4:"size";i:1089;s:5:"owner";O:8:"stdClass":2:{s:4:"name";s:13:"tempo-project";s:5:"email";N;}s:7:"private";b:0;s:11:"open_issues";i:1;s:10:"has_issues";b:1;s:13:"has_downloads";b:1;s:8:"has_wiki";b:1;s:8:"language";s:3:"PHP";s:10:"created_at";i:1336219060;s:9:"pushed_at";i:1382274091;s:13:"master_branch";s:6:"master";s:12:"organization";s:13:"tempo-project";}s:6:"commit";O:8:"stdClass":10:{s:2:"id";s:40:"9fd10fec0a9a0fda5e59b56c9f40bc3da69f9a1b";s:8:"distinct";b:1;s:7:"message";s:11:"Commit test";s:9:"timestamp";s:25:"2013-10-19T16:11:59-07:00";s:3:"url";s:86:"https://github.com/tempo-project/tempo/commit/9fd10fec0a9a0fda5e59b56c9f40bc3da69f9a1b";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:18:"Jérémy LEHERPEUR";s:5:"email";s:20:"jeremy@leherpeur.net";s:8:"username";s:9:"amenophis";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:18:"Jérémy LEHERPEUR";s:5:"email";s:20:"jeremy@leherpeur.net";s:8:"username";s:9:"amenophis";}s:5:"added";a:0:{}s:7:"removed";a:0:{}s:8:"modified";a:1:{i:0;s:60:"src/Tempo/Bundle/ActivityBundle/Providers/GithubProvider.php";}}}'));
            $activity->setCreated(new \DateTime('now'));
            $manager->persist($activity);
            $manager->flush();

            $this->addReference('activity_'.$i, $activity);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 7;
    }
}
