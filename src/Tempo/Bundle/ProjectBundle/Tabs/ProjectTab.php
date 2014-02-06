<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

class ProjectTab implements TabProviderInterface
{
    public function getId()
    {
        return "project";
    }

    public function getName()
    {
        return "Project";
    }

    public function getContent()
    {
        return "TempoProjectBundle:Project/Tabs:project.html.twig";
    }
}