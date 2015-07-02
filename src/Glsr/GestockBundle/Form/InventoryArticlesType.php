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
            ->add('id', 'integer')
            ->add('inventory')
            ->add('articles')
            ->add(
                'realstock',
                'number',
                array(
                    'grouping' => true,
                    'precision' => 3,
                    'data' => 0,
                )
            )
            ->add(
                'total',
                'number',
                array(
                    'grouping' => true,
                    'precision' => 3,
                    'data' => 0,
                    'read_only' => true,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => null));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_inventoryarticles';
    }
}
