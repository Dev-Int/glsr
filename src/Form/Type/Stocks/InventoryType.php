<?php
/**
 * InventoryType Form properties.
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
namespace App\Form\Type\Stocks;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * InventoryType Form properties.
 *
 * @category Form
 */
class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, ['label' => 'gestock.date', 'widget' => 'single_text',
                'format' => 'dd MMM yyyy', 'html5' => false, 'input' => 'datetime',
                'attr'  => ['class' => 'form-control',],])
            ->add('status', HiddenType::class)
            ->add('amount', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Stocks\Inventory',]);
    }

    public function getBlockPrefix()
    {
        return 'inventory';
    }
}
