<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;

\locale::setDefault('en');
$currency = Intl::getCurrencyBundle()->getCurrencyName('EUR');

class SettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inventory_style', 'choice', array(
                'choices' => array(
                    'global' => 'Global',
                    'zonestorage' => 'Zone Storage'
                ),
                'expanded' => TRUE,
                'multiple' => FALSE,
            ))
            ->add('calculation',     'choice', array(
                'choices' => array(
                    'fifo' => 'FIFO',
                    'weighted' => 'weighted'
                ),
                'expanded' => TRUE,
                'multiple' => FALSE,
            ))
            ->add('first_inventory', 'date', array(
                'input' => 'datetime'
            ))
            ->add('currency',        'currency', array(
                'multiple'         => FALSE,
                'expanded'         => FALSE,
                'preferred_choices' => array('EUR')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Glsr\GestockBundle\Entity\Settings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_settings';
    }
}
