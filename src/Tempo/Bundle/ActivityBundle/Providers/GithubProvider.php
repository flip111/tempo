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
        
        file_put_contents('/tmp/json.json', json_encode($request->getContent()));
        throw new \Exception('Not implemented yet');
    }
}