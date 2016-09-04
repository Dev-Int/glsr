<?php
/**
 * UserFilterType Form properties.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

/**
 * UserFilterType Form properties.
 *
 * @category   Form
 */
class UserFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add(
            'username',
            'filter_text',
            array(
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle',
                'attr' => array('class' => 'pull-right')
            )
        )
        ->add(
            'email',
            'filter_text',
            array(
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle',
                'attr' => array('class' => 'pull-right')
            )
        )
        ->add('enabled', 'filter_boolean', array('label' => 'Autorisé'))
        ->add(
            'groups',
            'filter_entity',
            array(
                'label' => 'Groupes',
                'class' => 'AppBundle\Entity\Group',
                'expanded' => true,
                'multiple' => true,
                'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                    $query = $filterQuery->getQueryBuilder();
                    $query->leftJoin($field, 'm');
                    // Filter results using orWhere matching ID
                    foreach ($values['value'] as $value) {
                        $query->orWhere($query->expr()->in('m.id', $value->getId()));
                    }
                },
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\User',
            'csrf_protection'   => false,
            'validation_groups' => array('filter'),
            'method'            => 'GET',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user_filter';
    }
}
