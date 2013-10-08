<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Calendar;


class Week extends PeriodAbstract implements \Iterator
{
    const MONDAY = 1;
    private $current = null;

    /**
     * @param \DateTime $start
     * @param int       $firstWeekday
     *
     * @throws \Exception
     */
    public function __construct(\DateTime $start, $firstWeekday = self::MONDAY)
    {
        if (!self::isValid($start)) {
            throw new Exception;
        }

        $this->begin = clone $start;
        $this->end = clone $start;
        $this->end->add(new \DateInterval('P7D'));

        if ($firstWeekday < 0 || $firstWeekday > 6) {
            throw new Exception(
                sprintf(
                    '"%s" is not a valid day. Days are between 0 (Sunday) and 6 (Friday)'
                )
            );
        }
        $this->firstWeekday = $firstWeekday;
    }

    /**
     * @param \DateTime $start
     *
     * @return bool
     */
    public static function isValid(\DateTime $start)
    {
        return true;
    }

    /**
     * @return mixed|null
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        if (!$this->valid()) {
            $this->current = new Day($this->begin, $this->firstWeekday);
        } else {
            $this->current = $this->current->getNext();
            if (!$this->contains($this->current->getBegin())) {
                $this->current = null;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->current->getBegin()->format('d-m-Y');
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return null !== $this->current;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->current = null;
        $this->next();
    }

    /**
     * Returns the week number
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('W');
    }

    /**
     * Returns a \DateInterval equivalent to the period
     *
     * @return \DateInterval
     */
    public static function getDateInterval()
    {
        return new \DateInterval('P1W');
    }

    /**
     * Checks if the given period is contained in the current period
     *
     * @param \DateTime $date
     *
     * @return bool true if the period contains this date
     */
    public function contains(\DateTime $date)
    {
        return $this->begin <= $date && $date < $this->end;
    }

    /**
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

}
