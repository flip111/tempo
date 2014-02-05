<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class SubProjectTab implements TabProviderInterface
{
    public function getTabId()
    {
        return "sub-projects";
    }

    public function getTabName()
    {
        return "Sub-Projects";
    }

    public function getTabContent()
    {
        return "TempoProjectBundle:Project/Tabs:subproject.html.twig";
    }
}