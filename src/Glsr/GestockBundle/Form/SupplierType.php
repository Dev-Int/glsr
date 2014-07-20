<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use libphonenumber\PhoneNumberFormat;

class SupplierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',         'text')
            ->add('address',      'text')
            ->add('zipcode',      'text')
            ->add('town',         'text')
            ->add('phone',        'tel', array(
                'default_region' => 'FR', 
                'format'         => PhoneNumberFormat::NATIONAL
            ))
            ->add('fax',          'tel', array(
                'default_region' => 'FR', 
                'format'         => PhoneNumberFormat::NATIONAL
            ))
            ->add('email',        'email')
            ->add('contact',      'text')
            ->add('gsm',          'tel', array(
                'default_region' => 'FR', 
                'format'         => PhoneNumberFormat::NATIONAL
            ))
            // Délai de livraison A = jour de Cmde, (B, C, D, E) = jour de livraison
            ->add('delaydeliv',   'choice', array(
                'choices' => array(
                    1 => 'A pour B',
                    2 => 'A pour C',
                    3 => 'A pour D',
                    4 => 'A pour E'
                )
            ))
            // Choix du jour de la semaine pour les Cmdes
            ->add('orderdate',    'choice', array(
                'choices' => array(
                    1 => 'Lundi',
                    2 => 'Mardi',
                    3 => 'Mercredi',
                    4 => 'Jeudi',
                    5 => 'Vendredi',
                    6 => 'Samedi',
                    7 => 'Dimanche',
                ),
                'expanded' => true,
                'multiple' => true
            ))
            /**
             * @todo #1 Créer une exception si aucune famille logistique
             */
            ->add('family_log',     'entity', array(
                'class'    => 'GlsrGestockBundle:FamilyLog',
                'property' => 'name',
                'multiple' => FALSE,
                'empty_value' => 'Choice the Family',
                'empty_data' => null
            ))
            /**
             * @todo Doit dépendre de family_log
             */
            ->add('sub_family_log', 'entity', array(
                'class'    => 'GlsrGestockBundle:SubFamilyLog',
                'property' => 'name',
                'multiple' => FALSE,
                'required' => FALSE,
                'empty_value' => 'Choice the Sub Family',
                'empty_data' => null
            ))
            ->add('active',     'checkbox')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Glsr\GestockBundle\Entity\Supplier'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_supplier';
    }
}
