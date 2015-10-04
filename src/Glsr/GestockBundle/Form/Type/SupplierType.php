<?php

/**
 * SupplierType Form properties.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: f912c90cc23014686059cf730526a2874e826553
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use libphonenumber\PhoneNumberFormat;

/**
 * SupplierType Form properties.
 *
 * @category   Form
 */
class SupplierType extends AbstractType
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
                    'label' => 'glsr.gestock.name'
                )
            )
            ->add(
                'address',
                'text',
                array(
                    'label' => 'glsr.gestock.address'
                )
            )
            ->add(
                'zipcode',
                'text',
                array(
                    'label' => 'glsr.gestock.address'
                )
            )
            ->add(
                'town',
                'text',
                array(
                    'label' => 'glsr.gestock.address',
                    'attr' => array(
                        'onBlur' => 'this.value=this.value.toUpperCase();',
                        'onFocus' => 'this.value=this.value.toUpperCase();',
                        'onKeyup' => 'this.value=this.value.toUpperCase();'
                    )
                )
            )
            ->add(
                'contact',
                'text',
                array(
                    'label' => 'glsr.gestock.contact'
                )
            )
            ->add(
                'gsm',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'glsr.gestock.gsm'
                )
            )
            ->add(
                'fax',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'glsr.gestock.fax'
                )
            )
            ->add(
                'phone',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'glsr.gestock.phone'
                )
            )
            ->add(
                'mail',
                'email',
                array(
                    'label' => 'glsr.gestock.mail'
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
                    'required' => false,
                    'placeholder' => 'glsr.gestock.settings.diverse.choice_subfam',
                    'empty_data' => null,
                    'label' => 'glsr.gestock.settings.diverse.subfamilylog'
                )
            )
            // Délai de livraison A = jour de Cmde, (B, C, D, E) = jour de livraison
            ->add(
                'delaydeliv',
                'choice',
                array(
                    'choices' => array(
                        1 => 'glsr.gestock.supplier.form.atob',
                        2 => 'glsr.gestock.supplier.form.atoc',
                        3 => 'glsr.gestock.supplier.form.atod',
                        4 => 'glsr.gestock.supplier.form.atoe',
                    ),
                    'label' => 'glsr.gestock.supplier.settings.delay'
                )
            )
            // Choix du jour de la semaine pour les Cmdes
            ->add(
                'orderdate',
                'choice',
                array(
                    'choices' => array(
                        1 => 'glsr.gestock.dates.mon',
                        2 => 'glsr.gestock.dates.tue',
                        3 => 'glsr.gestock.dates.wed',
                        4 => 'glsr.gestock.dates.thu',
                        5 => 'glsr.gestock.dates.fri',
                        6 => 'glsr.gestock.dates.sat',
                        7 => 'glsr.gestock.dates.sun',
                    ),
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'glsr.gestock.supplier.settings.order'
                )
            )
            ->add('active', 'hidden')
            ->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary'
                    ),
                    'label' => 'glsr.gestock.supplier.create.save'
                )
            )
            ->add(
                'addmore',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary'
                    ),
                    'label' => 'glsr.gestock.supplier.create.save&more'
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
                'data_class' => 'Glsr\GestockBundle\Entity\Supplier',
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
        return 'glsr_gestockbundle_supplier';
    }
}
