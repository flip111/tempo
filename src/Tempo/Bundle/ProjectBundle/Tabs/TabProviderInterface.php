<?php

namespace Tempo\Bundle\ProjectBundle\Tabs;

interface TabProviderInterface
{
    public function getId();
    public function getName();
    public function getContent();
}