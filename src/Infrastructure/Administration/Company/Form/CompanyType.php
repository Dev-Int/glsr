<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Infrastructure\Administration\Company\Form;

use Administration\Domain\Company\Model\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;

class CompanyType extends AbstractType
{
    final public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('address', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('zipCode', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('town', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('country', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('phone', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('facsimile', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotNull(),
                    new Email(),
                ],
            ])
            ->add('contact', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('cellphone', TextType::class, [
                'constraints' => new NotNull(),
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    final public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        return $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }

    final public function getBlockPrefix(): string
    {
        return 'company';
    }
}
