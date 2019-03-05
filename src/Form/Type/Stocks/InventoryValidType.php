<?php
/**
 * InventoryValidType Form properties.
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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * InventoryValidType Form properties.
 *
 * @category Form
 */
class InventoryValidType extends InventoryType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('date');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Stocks\Inventory']);
    }

    public function getBlockPrefix()
    {
        return 'inventory_valid';
    }
}
