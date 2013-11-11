<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Model;

use Tempo\Bundle\ActivityBundle\Model\EventsInterface;


class Events implements EventsInterface
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $data;

    /**
     *
     * @var object
     */
    protected $author;

    /**
     *
     * @var object
     */
    protected $createdAt;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * {@inheritdoc}
     */
    public function setTargetType($type)
    {
        $this->targetType = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        return $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthor($author)
    {
        return $this->author = $author;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}