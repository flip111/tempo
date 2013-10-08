<?php

namespace Tempo\Bundle\MainBundle\Calendar;


class Day extends PeriodAbstract
{
    public function __construct(\DateTime $begin, $firstWeekday = Day::MONDAY)
    {
        $this->begin = clone $begin;
        $this->end = clone $begin;
        $this->end->add(new \DateInterval('P1D'));

    }
}