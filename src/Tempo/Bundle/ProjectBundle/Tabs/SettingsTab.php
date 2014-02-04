<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class SettingsTab implements ProviderInterface
{
    public function getTabId()
    {
        return "settings";
    }

    public function getTabName()
    {
        return "Settings";
    }

    public function getTabContent()
    {
        return "TempoProjectBundle:Project/Tabs:settings.html.twig";
    }
}