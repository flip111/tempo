<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Manager;

use Tempo\Bundle\MainBundle\Manager\BaseManager;
use Tempo\Bundle\MainBundle\Entity\Timesheet;
use Tempo\Bundle\MainBundle\Calendar\Week;

use Doctrine\ORM\EntityManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class TimesheetManager extends BaseManager
{
    protected $em;
    protected $class;

    /**
     * @param $event
     * @param EntityManager $em
     * @param $class
     */
    public function __construct($event, EntityManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $this->em->getRepository($this->class);
    }

    /**
     * @param $week_lang
     * @param $user_id
     * @param  null  $weekbegin
     * @param  null  $weekend
     * @return array
     */
    public function getAllCra($weekLang, $user_id, $weekbegin = null, $weekend = null)
    {
        $yearOrStart = new \DateTime(sprintf('%s-W%s', date('Y'), str_pad(date('W'), 2, '0', STR_PAD_LEFT)));
        $factory = new Week($yearOrStart);

        $data = array(
            'date' => array(),
            'week' => array(),
            'projects' => array(),
        );

        //date of the week
        $i = 1;
        foreach ($factory as $day) {
            $data['date'][$i] = $day;
            $i++;
        }

        //weekday
        foreach ($weekLang as $key => $week) {
           $key++;
           $data['week'][$key] = $week . ' ' . $data['date'][$key]->format('d');
        }

        $projectsList = $this->em->getRepository('TempoProjectBundle:Project')->findAllTimeSheet($user_id, $weekbegin, $weekend);
        foreach ($projectsList as $project) {

            $projectName = $project->getName();

            $data['projects'][$projectName]['id'] = $project->getId();
            $data['projects'][$projectName]['name'] = $project->getName();
            $data['projects'][$projectName]['cras'][] = array();
            unset($data['projects'][$projectName]['cras'][0]); // @TODO fix bug indexe 0

            foreach ($project->getTimesheets() as $timesheet) {

                $dateFormat =  $timesheet->getPeriod()->format('j');

                if (empty($data['projects'][$projectName]['cras'][$dateFormat]['total'])) {
                    $data['projects'][$projectName]['cras'][$dateFormat]['total'] = 0;
                }

                if (empty($data['projects'][$projectName]['cras'][$dateFormat]['hours'])) {
                    $data['projects'][$projectName]['cras'][$dateFormat]['hours'] = 0;
                }

                $data['projects'][$projectName]['cras'][$dateFormat]['hours'] += $timesheet->getTime();
                $data['projects'][$projectName]['cras'][$dateFormat]['day'] = $dateFormat;
                $data['projects'][$projectName]['cras'][$dateFormat]['list'][] = $timesheet;
                asort($data['projects'][$projectName]['cras'][$dateFormat]['list']);

                $data['projects'][$projectName]['cras'][$dateFormat]['total']++;
            }

        }

        return $data;
    }
}
