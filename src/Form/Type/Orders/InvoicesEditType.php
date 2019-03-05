<?php
/**
 * InvoicesType Form properties.
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
namespace App\Form\Type\Orders;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\Orders\OrdersEditType;
use App\Form\Type\Orders\InvoicesArticlesType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * InvoicesEditType Form properties.
 *
 * @category Form
 */
class InvoicesEditType extends OrdersEditType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('articles');
        $builder->add('articles', CollectionType::class, ['entry_type' => InvoicesArticlesType::class]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Orders\Orders',]);
    }

    public function getBlockPrefix()
    {
        return 'invoices_edit';
    }
}
