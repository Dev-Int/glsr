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

namespace Administration\Infrastructure\Settings\Form\Type;

use Administration\Application\Settings\ReadModel\Settings;
use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class SettingsType extends AbstractType
{
    final public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currency', ChoiceType::class, [
                'constraints' => new NotNull(),
                'choices' => Currency::CURRENCY,
                'choice_label' => function ($choice, $key, $value) {
                    return \ucfirst($value);
                },
            ])
            ->add('locale', ChoiceType::class, [
                'constraints' => new NotNull(),
                'choices' => Locale::LOCALE,
                'choice_label' => function ($choice, $key, $value) {
                    return \strtoupper($value);
                },
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Configurer',
            ])
            ;
    }

    final public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        return $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }

    final public function getBlockPrefix(): string
    {
        return 'settings';
    }
}
