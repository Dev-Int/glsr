<?php
/**
 * InventoryEditType Form properties.
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
 * InventoryArticlesType Form properties.
 *
 * @category   Form
 */
class InventoryArticlesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'inventory',
                'entity',
                array(
                    'class' => 'AppBundle:Inventory',
                    'choice_label' => 'id',
                    'label' => 'gestock.id',
                    'translation_domain' => 'messages',
                    'empty_data' => null,
                    'attr'=> array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'article',
                'entity',
                array(
                    'class' => 'AppBundle:Article',
                    'choice_label' => 'name',
                    'label' => 'title',
                    'translation_domain' => 'gs_articles',
                    'empty_data' => null,
                    'attr'=> array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'quantity',
                'number',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'empty_data' => '0,000',
                    'label' => 'settings.quantity',
                    'translation_domain' => 'gs_articles',
                    'attr'=> array(
                        'class' => 'inventory form-control'
                    )
                )
            )
            ->add(
                'realstock',
                'number',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'empty_data' => '0,000',
                    'label' => 'seizure.realstock',
                    'translation_domain' => 'gs_inventories',
                    'attr'=> array(
                        'class' => 'inventory form-control'
                    )
                )
            )
            ->add(
                'unit_storage',
                'entity',
                array(
                    'class' => 'AppBundle:UnitStorage',
                    'choice_label' => 'abbr',
                    'label' => 'gestock.settings.diverse.unitstorage',
                    'empty_data' => null,
                    'attr'=> array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'price',
                'money',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'read_only' => true,
                    'label' => 'settings.price',
                    'translation_domain' => 'gs_articles',
                    'attr'=> array(
                        'class' => 'inventory form-control'
                    )
                )
            )
            ->add(
                'total',
                'money',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'read_only' => true,
                    'label' => 'seizure.total',
                    'translation_domain' => 'gs_inventories',
                    'mapped' => false,
                    'attr'=> array(
                        'class' => 'inventory form-control'
                    )
                )
            )
            ->add(
                'gap',
                'number',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'read_only' => true,
                    'label' => 'seizure.gap',
                    'translation_domain' => 'gs_inventories',
                    'mapped' => false,
                    'attr'=> array(
                        'class' => 'inventory form-control'
                    )
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
            'data_class' => 'AppBundle\Entity\InventoryArticles'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'inventoryarticles';
    }
}
