<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Providers;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;

class TrelloProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $payload = json_decode($request->get('payload'));

        $activities = array();

        foreach ($payload->commits as $commit) {
            $activity = new Activity();
            $activity->setProvider('trello');
            $activity->setMessage('tempo.activity.provider.trello.commit');
            $activity->setParameters(array(
                "repository" => $payload->board,
                "commit" => $commit
            ));

            $activities[] = $activity;
        }

        return $activities;
    }
}