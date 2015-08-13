<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InventoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                'integer',
                array(
                    'disabled' => true,
                )
            )
            ->add(
                'date',
                'date',
                array(
                    'widget' => 'single_text',
                    'disabled' => true,
                )
            )
            ->add(
                'amount',
                'money',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'read_only' => true
                )
            )
            ->add(
                $builder->create(
                    'articles',
                    'collection',
                    array(
                        'type' => new InventoryArticlesType()
                        )
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Glsr\GestockBundle\Entity\Inventory',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_inventory';
    }
}
