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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * InventoryEditType Form properties.
 *
 * @category   Form
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
            ->add(
                'articles',
                'collection',
                array('type' => new InventoryArticlesType())
            )
            ->add(
                'amount',
                'money',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'read_only' => true,
                    'label' => 'seizure.totals',
                    'translation_domain' => 'gs_inventories',
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
            'data_class' => 'AppBundle\Entity\Inventory'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'inventory_edit';
    }
}
