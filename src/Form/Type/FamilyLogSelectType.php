<?php

/**
 * Entity FamilyLog for select.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * FamilyLogSelectType Form properties.
 *
 * @category Form
 */
class FamilyLogSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['class' => 'App:Settings\Diverse\FamilyLog',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.path', 'ASC');
                }, ]
        );
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
