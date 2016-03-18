<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                null,
                array(
                    'label' => 'form.group_name',
                    'translation_domain' => 'FOSUserBundle'
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Group',
        ));
    }

    /**
     * {@inheritdoc}
     */
//    public function getParent()
//    {
//        //return 'FOS\UserBundle\Form\Type\RegistrationFormType';
//
//        // Or for Symfony < 2.8
//        return 'fos_user_group';
//    }

//    public function getBlockPrefix()
//    {
//        return 'app_user_group';
//    }

    // For Symfony 2.x
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'group';
        //return $this->getBlockPrefix();
    }
}
