<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'inventory_style',
                'choice',
                array(
                    'choices' => array(
                        'global' => 'gestock.settings.application.global',
                        'zonestorage' => 'gestock.settings.application.zone_storage',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'gestock.settings.application.style_inventory'
                )
            )
            ->add(
                'calculation',
                'choice',
                array(
                    'choices' => array(
                        'fifo' => 'gestock.settings.application.fifo',
                        'weighted' => 'gestock.settings.application.weighted',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'gestock.settings.application.calculation'
                )
            )
            ->add('first_inventory', 'hidden')
            ->add(
                'currency',
                'currency',
                array(
                    'multiple' => false,
                    'expanded' => false,
                    'preferred_choices' => array('EUR'),
                    'label' => 'gestock.settings.application.currency'
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Settings',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'application';
    }
}
