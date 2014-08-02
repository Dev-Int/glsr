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
            ->add('name',            'text')
            ->add('unit_bill',       'number', array(
                'precision'     => 3,
                'grouping'      => TRUE,
                'label'         => 'packaging'
            ))
            ->add('price',           'money', array(
                'precision'     => 3,
                'grouping'      => TRUE,
                'currency'      => 'EUR'
            ))
            ->add('quantity',        'number', array(
                'precision'     => 3,
                'grouping'      => TRUE,
            ))
            ->add('minstock',        'number', array(
                'precision'     => 3,
                'grouping'      => TRUE,
            ))
            ->add('realstock',       'number', array(
                'precision'     => 3,
                'grouping'      => TRUE,
                'data'          => 0
            ))
            ->add('active',       'checkbox')
            /**
             * @todo #15 Créer exception si aucun fournisseurs
             */
            ->add('supplier',       'entity', array(
                'class'    => 'GlsrGestockBundle:Supplier',
                'property' => 'name',
                'multiple' => FALSE,
                'empty_value' => 'Choice the Supplier',
                'empty_data' => null
            ))
            /**
             * @todo Créer une exception si aucune unité de stockage
             */
            ->add('unit_storage',   'entity', array(
                'class'    => 'GlsrGestockBundle:UnitStorage',
                'property' => 'name',
                'multiple' => FALSE
            ))
            /**
             * @todo Créer une exception si aucune zone de stockage
             */
            ->add('zone_storages',   'entity', array(
                'class'    => 'GlsrGestockBundle:ZoneStorage',
                'property' => 'name',
                'multiple' => TRUE,
                'expanded' => TRUE
            ))
            /**
             * @todo Créer une exception si aucune famille logistique
             */
            ->add('family_log',     'entity', array(
                'class'    => 'GlsrGestockBundle:FamilyLog',
                'property' => 'name',
                'multiple' => FALSE,
                'empty_value' => 'Choice the Family',
                'empty_data' => null
            ))
            /**
             * @todo Créer une exception si aucune sous-famille logistique
             */
            ->add('sub_family_log', 'entity', array(
                'class'    => 'GlsrGestockBundle:SubFamilyLog',
                'property' => 'name',
                'multiple' => FALSE,
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
