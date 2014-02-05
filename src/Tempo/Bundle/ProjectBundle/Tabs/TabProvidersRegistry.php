<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class TabProvidersRegistry
{
    protected $providers = array();

    public function addProvider($provider)
    {
        $this->providers[] = $provider;
    }

    public function getProviders()
    {
        return $this->providers;
    }
}