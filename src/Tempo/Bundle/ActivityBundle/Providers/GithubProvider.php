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
        $eventName = $request->headers->get('X-Github-Event');
        $payload = json_decode($request->get('payload'));

        $methodName = sprintf('%sEvent', $eventName);
        return $this->$methodName($payload);
    }

    protected function pushEvent($payload)
    {
        $activities = array();

        foreach ($payload->commits as $commit) {
            $activity = new Activity();
            $activity->setProvider('github');
            $activity->setMessage('tempo.activity.provider.github.commit');
            $activity->setDatetime(new \DateTime($commit->timestamp));
            $activity->setParameters(array(
                "repository" => $payload->repository,
                "commit" => $commit
            ));

            $activities[] = $activity;
        }

        return $activities;
    }

    protected function issuesEvent($payload)
    {
        // TODO
        return array();
    }

    protected function issue_commentEvent($payload)
    {
        // TODO
        return array();
    }

    protected function commit_commentEvent($payload)
    {
        // TODO
        return array();
    }

    protected function pull_requestEvent($payload)
    {
        // TODO
        return array();
    }

    protected function pull_request_review_commentEvent($payload)
    {
        // TODO
        return array();
    }

    protected function gollumEvent($payload)
    {
        // TODO
        return array();
    }

    protected function watchEvent($payload)
    {
        // TODO
        return array();
    }

    protected function releaseEvent($payload)
    {
        // TODO
        return array();
    }

    protected function forkEvent($payload)
    {
        // TODO
        return array();
    }

    protected function memberEvent($payload)
    {
        // TODO
        return array();
    }

    protected function publicEvent($payload)
    {
        // TODO
        return array();
    }

    protected function team_addEvent($payload)
    {
        // TODO
        return array();
    }

    protected function statusEvent($payload)
    {
        // TODO
        return array();
    }
}