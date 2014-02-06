<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class ActivityTab implements TabProviderInterface
{
    public function getId()
    {
        return "activity";
    }

    public function getName()
    {
        return "Activity";
    }

    public function getContent()
    {
        return "TempoProjectBundle:Project/Tabs:activity.html.twig";
    }
}