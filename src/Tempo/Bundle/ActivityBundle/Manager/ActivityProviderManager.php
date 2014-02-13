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

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Provider\ProviderInterface;
use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\ProjectBundle\Model\Project;

class ActivityProviderManager extends BaseManager
{
    /**
     * @var Container
     */
    protected $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @param $providerName
     * @return ProviderInterface
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

    public function add($providerName, Project $project, Request $request)
    {
        $activity = $this->getProvider($providerName)->parse($request);

        if (!$activity) {
            return;
        }

        $activity->setProject($project);
        $this->save($activity);
    }
}