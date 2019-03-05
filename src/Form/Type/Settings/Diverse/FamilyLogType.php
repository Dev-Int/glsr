<?php
/**
 * FamilyLogType Form properties.
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
namespace App\Form\Type\Settings\Diverse;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

use App\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * FamilyLogType Form properties.
 *
 * @category Form
 */
class FamilyLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'gestock.settings.diverse.family',])
            ->add(
                'parent',
                EntityType::class,
                array(
                    'class' => 'App:Settings\Diverse\FamilyLog',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->orderBy('f.path', 'ASC');
                    },
                    'choice_label' => 'indentedName',
                    'required' => false,
                    'label' => 'gestock.settings.diverse.parent_fam'
                )
            )
            ->addEventSubscriber(new AddSaveEditFieldSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Settings\Diverse\FamilyLog',
        ));
    }

    public function getBlockPrefix()
    {
        return 'familylog';
    }
}
