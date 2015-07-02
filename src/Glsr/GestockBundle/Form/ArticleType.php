<?php

/**
 * ArticleType Form properties.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: 66c30ad5658ae2ccc5f74e6258fa4716d852caf9
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * ArticleType Form properties.
 *
 * @category   Form
 */
class ArticleType extends AbstractType
{
    /**
     * buildForm.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     *
     * @return Form $form    Formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add(
                'packaging',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'packaging',
                )
            )
            ->add(
                'price',
                'money',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                )
            )
            ->add(
                'quantity',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                )
            )
            ->add(
                'minstock',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                )
            )
            ->add(
                'realstock',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'data' => 0,
                )
            )
            ->add('active', 'checkbox')
            ->add(
                'supplier',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:Supplier',
                    'property' => 'name',
                    'multiple' => false,
                    'empty_value' => 'Choice the Supplier',
                    'empty_data' => null,
                )
            )
            ->add(
                'unit_storage',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:UnitStorage',
                    'property' => 'name',
                    'multiple' => false,
                )
            )
            ->add(
                'zone_storages',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:ZoneStorage',
                    'property' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                )
            )
            ->add(
                'family_log',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:FamilyLog',
                    'property' => 'name',
                    'multiple' => false,
                    'empty_value' => 'Choice the Family',
                    'empty_data' => null,
                )
            )
            ->add(
                'sub_family_log',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:SubFamilyLog',
                    'property' => 'name',
                    'multiple' => false,
                    'empty_value' => 'Choice the Sub Family',
                    'empty_data' => null,
                )
            );
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     *
     * @return array DefaultOption
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Glsr\GestockBundle\Entity\Article',
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'glsr_gestockbundle_article';
    }
}
