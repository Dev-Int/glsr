<?php
/**
 * OrdersType Form properties.
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
use App\Form\Type\Orders\OrdersType;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * OrdersEditType Form properties.
 *
 * @category Form
 */
class OrdersEditType extends OrdersType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'supplier',
                EntityType::class,
                array(
                    'class' => 'App:Settings\Supplier',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.active = 1');
                    },
                    'required' => false,
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'form.choice_supplier',
                    'label' => 'title',
                    'translation_domain' => 'gs_suppliers',
                    'empty_data' => null,
                    'attr'  => ['class' => 'form-control', 'readonly' => true,],
                )
            )
            ->add(
                'orderdate',
                DateType::class,
                array(
                    'required' => false,
                    'label' => 'form.order_date',
                    'translation_domain' => 'gs_orders',
                    'widget' => 'single_text',
                    'format' => 'EEEE dd MMMM yyyy',
                    'html5' => false,
                    'input' => 'datetime',
                    'attr'  => ['class' => 'form-control', 'readonly' => true,],
                )
            )
            ->add(
                'delivdate',
                DateType::class,
                array(
                    'required' => false,
                    'label' => 'form.deliv_date',
                    'translation_domain' => 'gs_orders',
                    'widget' => 'single_text',
                    'format' => 'EEEE dd MMMM yyyy',
                    'html5' => false,
                    'input' => 'datetime',
                    'attr'  => ['class' => 'form-control', 'readonly' => true,],
                )
            )
            ->add(
                'amount',
                MoneyType::class,
                array(
                    'required' => false,
                    'scale' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'label' => 'seizure.totals',
                    'translation_domain' => 'gs_orders',
                    'attr'=> array(
                        'class' => 'form-control text-right',
                        'readonly' => true,
                    ),
                )
            )
            ->add(
                'tva',
                MoneyType::class,
                array(
                    'required' => false,
                    'scale' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'label' => 'seizure.vat',
                    'translation_domain' => 'gs_orders',
                    'attr'=> array(
                        'class' => 'form-control text-right',
                        'readonly' => true,
                    ),
                )
            )
            ->add('articles', CollectionType::class, ['entry_type' => OrdersArticlesType::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Orders\Orders',
        ));
    }

    public function getBlockPrefix()
    {
        return 'orders';
    }
}
