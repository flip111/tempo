<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;
use Tempo\Bundle\ProjectBundle\Entity\Project;

class ActivityProviderManager extends ContainerAware
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $container;

    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    protected function getProvider($providerName)
    {
        $serviceName = sprintf('tempo.activity.provider.%s', $providerName);

        if (!$this->container->has($serviceName)) {
            throw new \Exception(sprintf('Provider "%s" does not exists', $providerName));
        }

        return $this->container->get($serviceName);
    }

    public function add($id, Request $request)
    {

        $provider = $this->em->getRepository('TempoActivityBundle:ActivityProvider')->find($id);
        $provider = $this->getProvider(strtolower($provider->getProvider()));

        $activity = $provider->parse($request);

        $this->em->persist($activity);
        $this->em->flush();
    }

    public function getByProject(Project $project)
    {
        //foreach($project->)
        return $this->em->getRepository('TempoActivityBundle:Activity')->findByProject($project);
    }
}