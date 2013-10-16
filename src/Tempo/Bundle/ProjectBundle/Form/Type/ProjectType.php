<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Tempo\Bundle\ProjectBundle\Repository\ClientRepository;
use Tempo\Bundle\ProjectBundle\Entity\Project;

class ProjectType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', null, array('label' => 'projet_label_name' ))
                ->add('description', 'ckeditor')
                ->add('isActive', null, array('label' => 'projet_label_isactive'))
                ->add('beginning', 'date', array('label' => 'projet_label_beginning', 'widget' => 'single_text'))
                ->add('ending', 'date', array('label' => 'projet_label_ending','widget' => 'single_text'))
                ->add('type', 'choice', array('label' => 'projet_label_type', 'choices' => Project::$types) )
                ->add('avancement', null, array('label' => 'projet_label_avancement' ))
                ->add('code', null, array('label' => 'projet_label_code'))
                ->add('status', 'choice', array('label' => 'projet_label_status', 'choices' => Project::renderStatus()) )
                ->add('budget_estimated', null, array('label' => 'projet_label_estimated'))
                ->add('client', null, array(
                    'label' => 'projet_label_client',
                        'class' => 'TempoProjectBundle:Client',
                        'query_builder' => function(ClientRepository $er) {
                            return $er->findClientByUser(1);
                        }
                    )
                )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'user_id' => null,
            'data_class' => 'Tempo\Bundle\ProjectBundle\Entity\Project',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'project';
    }

}
