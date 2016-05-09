<?php
/**
 * InventoryType Form properties.
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
 * InventoryType Form properties.
 *
 * @category   Form
 */
class InventoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'date',
                'date',
                array(
                    'label' => 'gestock.date',
                    'widget' => 'single_text',
                    'format' => 'dd MMM yyyy',
                    'html5' => false,
                    'input' => 'datetime',
                )
            )
            ->add('status', 'hidden')
            ->add('amount', 'hidden')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Inventory',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'inventory';
    }
}
