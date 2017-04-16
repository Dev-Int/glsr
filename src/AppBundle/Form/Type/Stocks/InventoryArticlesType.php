<?php
/**
 * InventoryEditType Form properties.
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
namespace AppBundle\Form\Type\Stocks;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * InventoryArticlesType Form properties.
 *
 * @category Form
 */
class InventoryArticlesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inventory', EntityType::class, ['class' => 'AppBundle:Stocks\Inventory', 'choice_label' => 'id',
                'label' => 'gestock.id', 'translation_domain' => 'messages', 'empty_data' => null,
                'attr'=> ['class' => 'form-control', 'readonly' => true,],])
            ->add('article', EntityType::class, ['class' => 'AppBundle:Settings\Article', 'choice_label' => 'name',
                'label' => 'title', 'translation_domain' => 'gs_articles', 'empty_data' => null,
                'attr'=> ['class' => 'form-control', 'readonly' => true,],])
            ->add('quantity', NumberType::class, ['scale' => 3, 'grouping' => true, 'empty_data' => '0,000',
                    'label' => 'settings.quantity', 'translation_domain' => 'gs_articles',
                    'attr'=> ['class' => 'inventory form-control', 'readonly' => true,],])
            ->add('realstock', NumberType::class, ['scale' => 3, 'grouping' => true, 'empty_data' => '0,000',
                    'label' => 'seizure.realstock', 'translation_domain' => 'gs_inventories',
                    'attr'=> ['class' => 'inventory form-control',],])
            ->add('unitStorage', EntityType::class, ['class' => 'AppBundle:Settings\Diverse\UnitStorage',
                    'choice_label' => 'abbr', 'label' => 'gestock.settings.diverse.unitstorage', 'empty_data' => null,
                    'attr'=> ['class' => 'form-control', 'readonly' => true,],])
            ->add('price', MoneyType::class, ['scale' => 3, 'grouping' => true, 'currency' => 'EUR',
                    'label' => 'settings.price', 'translation_domain' => 'gs_articles',
                    'attr'=> ['class' => 'inventory form-control', 'readonly' => true,],])
            ->add('total', MoneyType::class, ['scale' => 3, 'grouping' => true, 'currency' => 'EUR',
                    'label' => 'seizure.total', 'translation_domain' => 'gs_inventories', 'mapped' => false,
                    'attr'=> ['class' => 'inventory form-control', 'readonly' => true,],])
            ->add('gap', NumberType::class, ['scale' => 3, 'grouping' => true, 'label' => 'seizure.gap',
                    'translation_domain' => 'gs_inventories', 'mapped' => false,
                    'attr'=> ['class' => 'inventory form-control', 'readonly' =>true,],]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Stocks\InventoryArticles']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'inventoryarticles';
    }
}