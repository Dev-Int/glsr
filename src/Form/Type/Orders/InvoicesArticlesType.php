<?php
/**
 * InvoicesArticlesType Form properties.
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

use App\Form\Type\Orders\OrdersArticlesType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * InvoicesArticlesType Form properties.
 *
 * @category Form
 */
class InvoicesArticlesType extends OrdersArticlesType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('quantity');
        $builder->remove('price');
        $builder
            ->add('quantity', NumberType::class, ['required' => false, 'scale' => 3, 'grouping' => true,
                'empty_data' => '0,000', 'label' => 'settings.quantity', 'translation_domain' => 'gs_articles',
                'attr'=> ['class' => 'form-control text-right', 'readonly' => true, ],])
            ->add('price', MoneyType::class, ['required' => true, 'scale' => 3, 'grouping' => true,
                'currency' => 'EUR', 'label' => 'settings.price', 'translation_domain' => 'gs_articles',
                'attr'=> ['class' => 'form-control text-right', ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Orders\OrdersArticles']);
    }

    public function getBlockPrefix()
    {
        return 'invoices_articles';
    }
}
