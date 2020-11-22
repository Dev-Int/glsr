<?php

namespace App\Form\Type;

use App\Entity\Settings\Diverse\FamilyLog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class FamilyLogSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            ['class' => FamilyLog::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.path', 'ASC');
                }]
        );
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
