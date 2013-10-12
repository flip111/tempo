<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Manager;

use Tempo\Bundle\MainBundle\Manager\BaseManager;
use Tempo\Bundle\MainBundle\Entity\Settings;

use Doctrine\ORM\EntityManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class SettingsManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository|mixed
     */
    public function getRepository()
    {
        return $this->em->getRepository('TempoMainBundle:Settings');
    }

    /**
     * @return array
     */
    public function loadOptions()
    {

        $optionsArray = $this->getRepository()->getAllOption();
        $settingsOption = array();


        foreach ($optionsArray as $soption) {
            $settings_option[] = array(
                'id' => $soption->getId(),
                'name' => $soption->getName(),
                'value' => $soption->getValue()
            );
        }

        return $settingsOption;

    }
}