<?php

namespace Tempo\Bundle\ActivityBundle\Providers;

use Tempo\Bundle\ActivityBundle\Entity\Activity;

interface ProviderInterface
{
    /**
     * @param $data
     * @return Activity
     */
    public function parse($data);
}