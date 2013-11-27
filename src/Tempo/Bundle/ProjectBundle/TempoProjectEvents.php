<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle;


final class TempoProjectEvents
{
    const PROJECT_CREATE_INITIALIZE = 'tempo_project.project.create.initialize';
    const PROJECT_CREATE_SUCCESS = 'tempo_project.project.create.success';
    const PROJECT_EDIT_INITIALIZE = 'tempo_project.project.edit.initialize';
    const PROJECT_EDIT_SUCCESS = 'tempo_project.project.edit.success';
    const PROJECT_DELETE_COMPLETED = 'tempo_project.project.delete.completed';

    const TIMESHEET_CREATE_INITIALIZE = 'tempo_project.timesheet.create.initialize';
    const TIMESHEET_CREATE_SUCCESS = 'tempo_project.timesheet.create.success';
    const TIMESHEET_EDIT_INITIALIZE = 'tempo_project.timesheet.edit.initialize';
    const TIMESHEET_EDIT_SUCCESS = 'tempo_project.timesheet.edit.success';
    const TIMESHEET_DELETE_COMPLETED = 'tempo_project.timesheet.delete.completed';
}