<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class SettingsTab implements TabProviderInterface
{
    public function getId()
    {
        return "settings";
    }

    public function getName()
    {
        return "Settings";
    }

    public function getContent()
    {
        return "TempoProjectBundle:Project/Tabs:settings.html.twig";
    }
}