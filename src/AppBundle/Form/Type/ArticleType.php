<?php
/**
 * ArticleType Form properties.
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

/**
 * ArticleType Form properties.
 *
 * @category   Form
 */
class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('name', 'text', array('label' => 'gestock.title_item'))
            ->add(
                'packaging',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'packaging',
                )
            )
            ->add(
                'price',
                'money',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'label' => 'settings.price',
                    'translation_domain' => 'gs_articles'
                )
            )
            ->add(
                'quantity',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'settings.quantity',
                    'translation_domain' => 'gs_articles'
                )
            )
            ->add(
                'minstock',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'settings.stock_alert',
                    'translation_domain' => 'gs_articles'
                )
            )
            ->add('active', 'checkbox', array('label' => 'gestock.actif'))
            ->add('slug', 'hidden')
            ->add(
                'supplier',
                'entity',
                array(
                    'class' => 'AppBundle:Supplier',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'form.choice_supplier',
                    'translation_domain' => 'gs_articles',
                    'empty_data' => null,
                )
            )
            ->add(
                'unit_storage',
                'entity',
                array(
                    'class' => 'AppBundle:UnitStorage',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'label' => 'gestock.settings.diverse.unitstorage'
                )
            )
            ->add(
                'zone_storages',
                'entity',
                array(
                    'class' => 'AppBundle:ZoneStorage',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'gestock.settings.diverse.zonestorage'
                )
            )
            ->add(
                'family_log',
                'entity',
                array(
                    'class' => 'AppBundle:FamilyLog',
                    'choice_label' => 'indentedName',
                    'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family',
                    'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog'
                )
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'article';
    }
}
