<?php
/**
 * InvoicesArticlesType Form properties.
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
namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Form\Type\OrdersArticlesType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * InvoicesArticlesType Form properties.
 *
 * @category Form
 */
class InvoicesArticlesType extends OrdersArticlesType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('quantity');
        $builder->remove('price');
        $builder
            ->add(
                'quantity',
                NumberType::class,
                array(
                    'required' => false,
                    'scale' => 3,
                    'grouping' => true,
                    'empty_data' => '0,000',
                    'label' => 'settings.quantity',
                    'translation_domain' => 'gs_articles',
                    'attr'=> ['class' => 'form-control text-right', 'readonly' => true, ],
                )
            )
            ->add(
                'price',
                MoneyType::class,
                array(
                    'required' => true,
                    'scale' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'label' => 'settings.price',
                    'translation_domain' => 'gs_articles',
                    'attr'=> ['class' => 'form-control text-right', ]
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
            'data_class' => 'AppBundle\Entity\OrdersArticles'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'invoicesarticles';
    }
}
