<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

interface ProviderInterface
{
    public function getTabId();
    public function getTabName();
    public function getTabContent();
}