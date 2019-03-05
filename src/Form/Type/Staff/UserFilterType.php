<?php
/**
 * UserFilterType Form properties.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Form\Type\Staff;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

/**
 * UserFilterType Form properties.
 *
 * @category Form
 */
class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'filter_text', ['label' => 'form.username', 'translation_domain' => 'FOSUserBundle',
                'attr' => ['class' => 'pull-right',],])
            ->add('email', 'filter_text', ['label' => 'form.email', 'translation_domain' => 'FOSUserBundle',
                'attr' => ['class' => 'pull-right',],])
            ->add('enabled', 'filter_boolean', ['label' => 'Autorisé',])
            ->add(
                'groups',
                'filter_entity',
                ['label' => 'Groupes', 'class' => 'App\Entity\Staff\Group', 'expanded' => true,
                    'multiple' => true, 'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                        $query = $filterQuery->getQueryBuilder();
                        $query->leftJoin($field, 'm');
                        // Filter results using orWhere matching ID
                        foreach ($values['value'] as $value) {
                            $query->orWhere($query->expr()->in('m.id', $value->getId()));
                        }
                    },
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Staff\User', 'csrf_protection' => false,
            'validation_groups' => ['filter'], 'method' => 'GET',]);
    }

    public function getBlockPrefix()
    {
        return 'user_filter';
    }
}