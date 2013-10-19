<?php

namespace Tempo\Bundle\ActivityBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;

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

    public function add($providerName, Request $request)
    {
        $provider = $this->getProvider($providerName);
        $activity = $provider->parse($request);
        $this->em->persist($activity);
        $this->em->flush();
    }

    protected function getProvider($providerName)
    {
        $serviceName = sprintf('tempo.activity.provider.%s', $providerName);

        if (!$this->container->has($serviceName)) {
            throw new \Exception(sprintf('Provider "%s" does not exists', $providerName));
        }

        return $this->container->get($serviceName);
    }
}