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

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\ActivityBundle\TempoActivityEvents;
use Tempo\Bundle\ActivityBundle\Event\ActivityProviderEvent;


class ActivityProviderManager extends BaseManager
{
    protected $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @param $providerName
     * @return \Tempo\Bundle\ActivityBundle\Provider\ProviderInterface
     * @throws \Exception
     */
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

        $projectProvider = $this->em->getRepository('TempoProjectBundle:ProjectProvider')->find($id);
        $provider = $this->getProvider(strtolower($projectProvider->getName()));


        /** @var \Tempo\Bundle\ActivityBundle\Model\ActivityProviderInterface $activity */
        $activity = $provider->parse($request);
        $activity->setProvider($projectProvider);

        $event = new ActivityProviderEvent($projectProvider, $request);
        $this->container->get('event_dispatcher')->dispatch(TempoActivityEvents::ACTIVITY_PROVIDER_CREATE_INITIALIZE, $event);

        $this->save($activity);
        $this->container->get('event_dispatcher')->dispatch(TempoActivityEvents::ACTIVITY_PROVIDER_CREATE_SUCCESS, $event);

    }
}