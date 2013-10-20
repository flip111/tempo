<?php

namespace Tempo\Bundle\ActivityBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

interface ProviderInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function parse(Request $request);
}