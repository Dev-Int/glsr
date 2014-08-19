<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Glsr\GestockBundle\Entity\Settings;

/**
 * Article Form properties
 */
class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('packaging', 'number', array(
                'precision'     => 3,
                'grouping'      => true,
                'label'         => 'packaging'
            ))
            ->add('price', 'money', array(
                'precision'     => 3,
                'grouping'      => true,
                'currency'      => 'EUR'
            ))
            ->add('quantity', 'number', array(
                'precision'     => 3,
                'grouping'      => true,
            ))
            ->add('minstock', 'number', array(
                'precision'     => 3,
                'grouping'      => true,
            ))
            ->add('realstock', 'number', array(
                'precision'     => 3,
                'grouping'      => true,
                'data'          => 0
            ))
            ->add('active', 'checkbox')
            ->add('supplier', 'entity', array(
                'class'    => 'GlsrGestockBundle:Supplier',
                'property' => 'name',
                'multiple' => false,
                'empty_value' => 'Choice the Supplier',
                'empty_data' => null
            ))
            ->add('unit_storage', 'entity', array(
                'class'    => 'GlsrGestockBundle:UnitStorage',
                'property' => 'name',
                'multiple' => false
            ))
            ->add('zone_storages', 'entity', array(
                'class'    => 'GlsrGestockBundle:ZoneStorage',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('family_log', 'entity', array(
                'class'    => 'GlsrGestockBundle:FamilyLog',
                'property' => 'name',
                'multiple' => false,
                'empty_value' => 'Choice the Family',
                'empty_data' => null
            ))
            ->add('sub_family_log', 'entity', array(
                'class'    => 'GlsrGestockBundle:SubFamilyLog',
                'property' => 'name',
                'multiple' => false,
                'empty_value' => 'Choice the Sub Family',
                'empty_data' => null
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Glsr\GestockBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_article';
    }
}
