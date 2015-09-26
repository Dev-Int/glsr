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
namespace Glsr\GestockBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add(
                'name',
                'text',
                array(
                    'label' => 'glsr.gestock.title_item'
                )
            )
            ->add(
                'supplier',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:Supplier',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'glsr.gestock.article.form.choice_supplier',
                    'empty_data' => null,
                    'label' => 'glsr.gestock.supplier.title'
                )
            )
            ->add(
                'active',
                'hidden',
                array(
                    'label' => 'glsr.gestock.actif'
                )
            )
            ->add(
                'zone_storages',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:ZoneStorage',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'glsr.gestock.settings.diverse.zonestorage'
                )
            )
            ->add(
                'family_log',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:FamilyLog',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'glsr.gestock.settings.diverse.choice_family',
                    'empty_data' => null,
                    'label' => 'glsr.gestock.settings.diverse.familylog'
                )
            )
            ->add(
                'sub_family_log',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:SubFamilyLog',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'glsr.gestock.settings.diverse.choice_subfam',
                    'empty_data' => null,
                    'label' => 'glsr.gestock.settings.diverse.subfamilylog'
                )
            )
            ->add(
                'quantity',
                'number',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'label' => 'glsr.gestock.article.settings.quantity'
                )
            )
            ->add(
                'unit_storage',
                'entity',
                array(
                    'class' => 'GlsrGestockBundle:UnitStorage',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'label' => 'glsr.gestock.settings.diverse.unitstorage'
                )
            )
            ->add(
                'price',
                'money',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'label' => 'glsr.gestock.article.settings.price'
                )
            )
            ->add(
                'packaging',
                'number',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'label' => 'glsr.gestock.article.settings.packaging'
                )
            )
            ->add(
                'minstock',
                'number',
                array(
                    'scale' => 3,
                    'grouping' => true,
                    'label' => 'glsr.gestock.article.settings.stock_alert'
                )
            );
    }

    /**
     * Configure the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     *
     * @return array DefaultOption
     */
    public function configureOptions(OptionsResolver$resolver)
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
