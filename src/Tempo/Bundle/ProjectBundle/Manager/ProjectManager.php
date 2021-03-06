<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class ProjectManager extends BaseManager
{
    /**
     * @param $slug
     * @return mixed
     */
    public function getProject($primaryKey)
    {
        if (is_string($primaryKey)) {
            $project =  $this->repository->findOneBySlug($primaryKey);
        } else {
            $project =  $this->repository->find($primaryKey);
        }

        return $project;
    }
}