<?php

namespace Tempo\Bundle\ActivityBundle\Providers;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;

class GithubProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $payload = json_decode($request->get('payload'));

        $activities = [];

        foreach ($payload->commits as $commit) {
            $activity = new Activity();
            $activity->setProvider('github');
            $activity->setMessage('tempo.activity.provider.github.commit');
            $activity->setParameters([
                "repository" => $payload->repository,
                "commit" => $commit
            ]);

            $activities[] = $activity;
        }

        return $activities;
    }
}