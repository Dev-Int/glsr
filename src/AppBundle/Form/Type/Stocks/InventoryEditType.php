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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Form\Type\Stocks\InventoryArticlesType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * InventoryEditType Form properties.
 *
 * @category Form
 */
class InventoryEditType extends InventoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('status')
            ->add('articles', CollectionType::class, ['entry_type' => InventoryArticlesType::class])
            ->add('amount', MoneyType::class, ['scale' => 3, 'grouping' => true, 'currency' => 'EUR',
                'label' => 'seizure.totals', 'translation_domain' => 'gs_inventories',
                'attr'=> ['class' => 'inventory form-control', 'readonly' => true]]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Stocks\Inventory']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'inventory_edit';
    }
}
