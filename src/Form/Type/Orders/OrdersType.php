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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * OrdersType Form properties.
 *
 * @category Form
 */
class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('supplier', EntityType::class, ['class' => 'App:Settings\Supplier',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')->where('s.active = 1');
                }, 'required' => false, 'choice_label' => 'name', 'multiple' => false,
                'placeholder' => 'form.choice_supplier', 'label' => 'title', 'translation_domain' => 'gs_suppliers',
                'empty_data' => null, 'attr'  => ['class' => 'form-control',],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Orders\Orders',]);
    }

    public function getBlockPrefix()
    {
        return 'orders';
    }
}
