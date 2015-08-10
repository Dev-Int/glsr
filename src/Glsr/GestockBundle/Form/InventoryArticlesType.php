<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InventoryArticlesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array(
                    'read_only' => true
                )
            )
            ->add(
                'quantity',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'disabled' => true
                )
            )
            ->add(
                'realstock',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'empty_data' => 0,
                    'attr'=> array(
                        'class'=>'inventory',
                        )
                )
            )
            ->add(
                'unit_storage',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:UnitStorage',
                    'property' => 'name',
                    'multiple' => false,
                    'disabled' => true
                )
            )
            ->add(
                'packaging',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'packaging',
                    'disabled' => true
                )
            )
            ->add(
                'price',
                'money',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'disabled' => true
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Glsr\GestockBundle\Entity\Article'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_inventoryarticles';
    }
}
