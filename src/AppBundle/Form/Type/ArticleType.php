<?php
/**
 * ArticleType Form properties.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use AppBundle\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * ArticleType Form properties.
 *
 * @category Form
 */
class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add(
                'name',
                TextType::class,
                ['label' => 'gestock.title_item', 'attr'  => ['class' => 'form-control'],]
            )
            ->add(
                'packaging',
                NumberType::class,
                ['scale' => 3, 'grouping' => true, 'label' => 'settings.packaging',
                    'translation_domain' => 'gs_articles', 'attr'  => ['class' => 'form-control'],]
            )
            ->add(
                'price',
                MoneyType::class,
                ['scale' => 3, 'grouping' => true, 'currency' => 'EUR', 'label' => 'settings.price',
                    'translation_domain' => 'gs_articles', 'attr'  => ['class' => 'form-control'],]
            )
            ->add(
                'tva',
                EntityType::class,
                ['class' => 'AppBundle:Tva', 'choice_label' => 'name', 'multiple' => false,
                    'label' => 'gestock.settings.diverse.vat', 'attr'  => ['class' => 'form-control'],]
            )
            ->add('quantity', HiddenType::class, ['data' => 0])
            ->add(
                'minstock',
                NumberType::class,
                ['scale' => 3, 'grouping' => true, 'label' => 'settings.stock_alert',
                    'translation_domain' => 'gs_articles', 'attr'  => ['class' => 'form-control'],]
            )
            ->add('active', HiddenType::class, ['data' => true])
            ->add('slug', HiddenType::class)
            ->add(
                'supplier',
                EntityType::class,
                array(
                    'class' => 'AppBundle:Supplier',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.active = 1');
                    },
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'form.choice_supplier',
                    'label' => 'title',
                    'translation_domain' => 'gs_suppliers',
                    'empty_data' => null,
                    'attr'  => ['class' => 'form-control'],
                )
            )
            ->add(
                'unitStorage',
                EntityType::class,
                ['class' => 'AppBundle:UnitStorage', 'choice_label' => 'name', 'multiple' => false,
                    'label' => 'gestock.settings.diverse.unitstorage', 'attr'  => ['class' => 'form-control'],]
            )
            ->add(
                'zoneStorages',
                EntityType::class,
                ['class' => 'AppBundle:ZoneStorage', 'choice_label' => 'name', 'multiple' => true, 'expanded' => true,
                    'label' => 'gestock.settings.diverse.zonestorage', 'attr'  => ['class' => 'form-control'],]
            )
            ->add(
                'familyLog',
                EntityType::class,
                [
                    'class' => 'AppBundle:FamilyLog',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->orderBy('f.path', 'ASC');
                    },
                    'choice_label' => 'indentedName',
                    'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family',
                    'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog',
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->addEventSubscriber(new AddSaveEditFieldSubscriber())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Article',]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'article';
    }
}
