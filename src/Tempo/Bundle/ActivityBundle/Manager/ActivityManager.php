<?php

namespace Tempo\Bundle\ActivityBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAware;
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

    public function add($providerName, $data)
    {
        $provider = $this->getProvider($providerName);
        $activity = $provider->parse($data);
        $this->em->persist($activity);
        $this->em->flush();
    }

    protected function getProvider($providerName)
    {
        $serviceName = sprintf('tempo.activity_provider.%s', $providerName);

        if (!$this->container->has($serviceName)) {
            throw new \Exception(sprintf('Provider "%s" does not exists', $providerName));
        }

        return $this->container->get($serviceName);
    }
}