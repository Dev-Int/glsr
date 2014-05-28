<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('unit_bill',       'text')
            ->add('price',           'text')
            ->add('quantity',        'text')
            ->add('minstock',        'text')
            ->add('realstock',       'text')
            ->add('active',       'checkbox')
            /**
             * @todo Créer exception si aucun fournisseurs
             */
            ->add('supplier',       'entity', array(
                'class'    => 'GlsrGestockBundle:Supplier',
                'property' => 'name',
                'multiple' => FALSE
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
                'multiple' => TRUE
            ))
            /**
             * @todo Créer une exception si aucune famille logistique
             */
            ->add('family_log',     'entity', array(
                'class'    => 'GlsrGestockBundle:FamilyLog',
                'property' => 'name',
                'multiple' => FALSE
            ))
            /**
             * @todo Créer une exception si aucune sous-famille logistique
             * @todo Doit dépendre de family_logs
             */
            ->add('sub_family_log', 'entity', array(
                'class'    => 'GlsrGestockBundle:SubFamilyLog',
                'property' => 'name',
                'multiple' => FALSE
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
