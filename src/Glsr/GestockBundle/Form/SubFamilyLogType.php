<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubFamilyLogType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',      'text')
            ->add('familylog', 'entity', array(
                'class' => 'GlsrGestockBundle:FamilyLog',
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
            'data_class' => 'Glsr\GestockBundle\Entity\SubFamilyLog'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_subfamilylog';
    }
}
