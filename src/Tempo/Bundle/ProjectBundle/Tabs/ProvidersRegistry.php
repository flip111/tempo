<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class ProvidersRegistry
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