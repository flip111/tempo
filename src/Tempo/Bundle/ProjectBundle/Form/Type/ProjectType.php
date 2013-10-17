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
            ->add('name', 'text', array(
                'label' => 'project.form.label.name',
            ))
            ->add('description', 'ckeditor', array(
                'required' => false,
                'label'    => 'project.form.label.isactive'
            ))
            ->add('isActive', null, array(
                'label' => 'project.form.label.isactive'
            ))
            ->add('beginning', 'date', array(
                'label' => 'project.form.label.beginning',
                'widget' => 'single_text'
            ))
            ->add('ending', 'date', array(
                'label' => 'project.form.label.ending',
                'widget' => 'single_text'
            ))
            ->add('type', 'choice', array(
                'label' => 'project.form.label.type', 'choices' => Project::$types
            ))
            ->add('avancement', null, array(
                'label' => 'project.form.label.avancement'
            ))
            ->add('code', null, array(
                'label' => 'project.form.label.code'
            ))
            ->add('status', 'choice', array(
                'label' => 'project.form.label.status',
                'choices' => Project::renderStatus()
            ))
            ->add('budget_estimated', null, array(
                'label' => 'project.form.label.estimated'
            ))
            ->add('client', null, array(
                'label' => 'project.form.label.client',
                'class' => 'TempoProjectBundle:Client',
                'query_builder' => function(ClientRepository $er) {
                    return $er->findClientByUser(1);
                }
            ))
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
            'translation_domain' => 'TempoProject'
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
