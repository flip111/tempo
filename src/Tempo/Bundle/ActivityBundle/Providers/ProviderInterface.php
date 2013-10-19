<?php

namespace Tempo\Bundle\ActivityBundle\Providers;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;

interface ProviderInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function parse(Request $request);
}