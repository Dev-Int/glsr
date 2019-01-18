<?php

namespace App\Form\Type;

use App\Entity\Staff\User2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->roles = $options['roles'];
        $builder
            ->add('email')
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => $this->roles,
                    'label' => 'Roles',
                    'expanded' => true,
                    'multiple' => true,
                    'mapped' => true,
                ]
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User2::class,
            'roles' => null,
        ]);
    }
}
