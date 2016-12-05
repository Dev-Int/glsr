<?php
/**
 * OrdersType Form properties.
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

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * OrdersType Form properties.
 *
 * @category   Form
 */
class OrdersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'supplier',
                EntityType::class,
                array(
                    'class' => 'AppBundle:Supplier',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.active = 1');
                    },
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'form.choice_supplier',
                    'label' => 'title',
                    'translation_domain' => 'gs_suppliers',
                    'empty_data' => null,
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add('amount', HiddenType::class)
            ->add('tva', HiddenType::class)
            ->add('status', HiddenType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Orders',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'orders';
    }
}
