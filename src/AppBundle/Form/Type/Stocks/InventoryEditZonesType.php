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

use AppBundle\Form\Type\Stocks\InventoryArticlesZonesType;
use AppBundle\Form\Type\Stocks\InventoryEditType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * InventoryEditType Form properties.
 *
 * @category Form
 */
class InventoryEditZonesType extends InventoryEditType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('articles')
            ->add('articles', CollectionType::class, ['entry_type' => InventoryArticlesZonesType::class,]);
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
