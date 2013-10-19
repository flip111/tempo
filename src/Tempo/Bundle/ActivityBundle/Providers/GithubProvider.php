<?php

namespace Tempo\Bundle\ActivityBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

class GithubProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        throw new \Exception('Not implemented yet');
    }
}