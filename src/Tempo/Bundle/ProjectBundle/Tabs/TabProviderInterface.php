<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

interface TabProviderInterface
{
    public function getTabId();
    public function getTabName();
    public function getTabContent();
}