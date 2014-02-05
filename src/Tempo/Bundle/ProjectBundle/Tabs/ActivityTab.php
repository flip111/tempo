<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class ActivityTab implements TabProviderInterface
{
    public function getTabId()
    {
        return "activity";
    }

    public function getTabName()
    {
        return "Activity";
    }

    public function getTabContent()
    {
        return "TempoProjectBundle:Project/Tabs:activity.html.twig";
    }
}