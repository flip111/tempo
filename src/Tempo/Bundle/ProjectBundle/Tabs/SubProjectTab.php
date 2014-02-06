<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class SubProjectTab implements TabProviderInterface
{
    public function getId()
    {
        return "sub-projects";
    }

    public function getName()
    {
        return "Sub-Projects";
    }

    public function getContent()
    {
        return "TempoProjectBundle:Project/Tabs:subproject.html.twig";
    }
}