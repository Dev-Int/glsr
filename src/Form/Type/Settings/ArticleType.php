<?php
/**
 * ArticleType Form properties.
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
namespace App\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use App\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * ArticleType Form properties.
 *
 * @category Form
 */
class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'gestock.title_item', 'attr'  => ['class' => 'form-control',],])
            ->add('packaging', NumberType::class, ['scale' => 3, 'grouping' => true, 'label' => 'settings.packaging',
                'translation_domain' => 'gs_articles', 'attr'  => ['class' => 'form-control',],])
            ->add('price', MoneyType::class, ['scale' => 3, 'grouping' => true, 'currency' => 'EUR',
                'label' => 'settings.price', 'translation_domain' => 'gs_articles',
                'attr'  => ['class' => 'form-control',],])
            ->add('tva', EntityType::class, ['class' => 'App:Settings\Diverse\Tva', 'choice_label' => 'name',
                'multiple' => false, 'label' => 'gestock.settings.diverse.vat',
                'attr'  => ['class' => 'form-control',],])
            ->add('quantity', HiddenType::class)
            ->add('minstock', NumberType::class, ['scale' => 3, 'grouping' => true, 'label' => 'settings.stock_alert',
                'translation_domain' => 'gs_articles', 'attr'  => ['class' => 'form-control',],])
            ->add('active', CheckboxType::class, ['required' => false, 'label' => 'gestock.actif',])
            ->add('supplier', EntityType::class, ['class' => 'App:Settings\Supplier',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.active = 1');
                    }, 'choice_label' => 'name', 'multiple' => false, 'placeholder' => 'form.choice_supplier',
                    'label' => 'title', 'translation_domain' => 'gs_suppliers', 'empty_data' => null,
                    'attr'  => ['class' => 'form-control',],])
            ->add('unitStorage', EntityType::class, ['class' => 'App:Settings\Diverse\Unit',
                'choice_label' => 'name', 'multiple' => false, 'label' => 'gestock.settings.diverse.unitstorage',
                'attr'  => ['class' => 'form-control',],])
            ->add('unitWorking', EntityType::class, ['class' => 'App:Settings\Diverse\Unit',
                'choice_label' => 'name', 'multiple' => false, 'label' => 'gestock.settings.diverse.unitworking',
                'attr'  => ['class' => 'form-control',],])
            ->add('zoneStorages', EntityType::class, ['class' => 'App:Settings\Diverse\ZoneStorage',
                'choice_label' => 'name', 'multiple' => true, 'expanded' => true,
                'label' => 'gestock.settings.diverse.zonestorage', 'attr'  => ['class' => 'form-control',],])
            ->add('familyLog', EntityType::class, ['class' => 'App:Settings\Diverse\FamilyLog',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->orderBy('f.path', 'ASC');
                    }, 'choice_label' => 'indentedName', 'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family', 'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog', 'attr'  => ['class' => 'form-control',],])
            ->addEventSubscriber(new AddSaveEditFieldSubscriber())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Settings\Article',]);
    }

    public function getBlockPrefix()
    {
        return 'article';
    }
}
