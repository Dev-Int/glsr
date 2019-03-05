<?php
/**
 * InventoryArticlesZonesType Form properties.
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

use App\Form\Type\Stocks\InventoryArticlesType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * InventoryArticlesZonesType Form properties.
 *
 * @category Form
 */
class InventoryArticlesZonesType extends InventoryArticlesType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('zoneStorage', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Stocks\InventoryArticles',]);
    }

    public function getBlockPrefix()
    {
        return 'inventory_articles';
    }
}
