<?php
/**
 * OrdersArticlesType Form properties.
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
namespace AppBundle\Form\Type\Orders;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * OrdersArticlesType Form properties.
 *
 * @category Form
 */
class OrdersArticlesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orders', EntityType::class, ['required' => false, 'class' => 'AppBundle:Orders\Orders',
                'choice_label' => 'id', 'label' => 'gestock.id', 'translation_domain' => 'messages',
                'empty_data' => null,])
            ->add('article', EntityType::class, ['required' => false, 'class' => 'AppBundle:Settings\Article',
                'choice_label' => 'name', 'label' => 'title', 'translation_domain' => 'gs_articles',
                'empty_data' => null,])
            ->add('quantity', NumberType::class, ['scale' => 3, 'grouping' => true, 'empty_data' => '0,000',
                'label' => 'settings.quantity', 'translation_domain' => 'gs_articles',
                'attr'=> ['class' => 'form-control text-right',],])
            ->add('unitStorage', EntityType::class, ['required' => false, 'class' => 'AppBundle:Settings\Diverse\Unit',
                'choice_label' => 'abbr', 'label' => 'gestock.settings.diverse.unitstorage', 'empty_data' => null,])
            ->add('price', MoneyType::class, ['required' => false, 'scale' => 3, 'grouping' => true,
                'currency' => 'EUR', 'label' => 'settings.price', 'translation_domain' => 'gs_articles',
                'attr'=> ['class' => 'form-control text-right', 'readonly' => true,],])
            ->add('tva', EntityType::class, ['required' => false, 'class' => 'AppBundle:Settings\Diverse\Tva',
                'choice_label' => 'name', 'choice_value' => 'rate', 'label' => 'gestock.settings.diverse.vat',
                'empty_data' => null,])
            ->add('total', MoneyType::class, ['required' => false, 'scale' => 3, 'grouping' => true,
                'currency' => 'EUR', 'label' => 'seizure.total', 'translation_domain' => 'gs_orders',
                'mapped' => false, 'attr'=> ['class' => 'form-control text-right', 'readonly' => true,],])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Orders\OrdersArticles']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'orders_articles';
    }
}
