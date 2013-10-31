<?php

namespace Tempo\Bundle\ActivityBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;
use Tempo\Bundle\ProjectBundle\Entity\Project;

class ActivityManager extends ContainerAware
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    protected function getProvider($providerName)
    {
        $serviceName = sprintf('tempo.activity.provider.%s', $providerName);

        if (!$this->container->has($serviceName)) {
            throw new \Exception(sprintf('Provider "%s" does not exists', $providerName));
        }

        return $this->container->get($serviceName);
    }

    public function add($providerName, Request $request)
    {
        $provider = $this->getProvider($providerName);
        $activities = $provider->parse($request);

        foreach ($activities as $activity) {
            $this->em->persist($activity);
        }
        $this->em->flush();
    }

    public function getByProject(Project $project)
    {
        //foreach($project->)
        return $this->em->getRepository('TempoActivityBundle:Activity')->findByProject($project);
    }
}