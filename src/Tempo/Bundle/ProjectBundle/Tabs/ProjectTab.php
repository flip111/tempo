<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class ProjectTab implements ProviderInterface
{
    public function getTabId()
    {
        return "project";
    }

    public function getTabName()
    {
        return "Project";
    }

    public function getTabContent()
    {
        return "TempoProjectBundle:Project/Tabs:project.html.twig";
    }
}