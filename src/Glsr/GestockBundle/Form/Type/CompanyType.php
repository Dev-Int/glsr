<?php

/**
 * CompanyType Form properties.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace Glsr\GestockBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use libphonenumber\PhoneNumberFormat;

/**
 * CompanyType Form properties.
 *
 * @category   Form
 */
class CompanyType extends AbstractType
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
                    'label' => 'glsr.gestock.settings.company.name'
                )
            )
            ->add(
                'status',
                'text',
                array(
                    'label' => 'glsr.gestock.settings.company.status'
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
                    'label' => 'glsr.gestock.zipcode'
                )
            )
            ->add(
                'town',
                'text',
                array(
                    'label' => 'glsr.gestock.town',
                    'attr' => array(
                        'onBlur' => 'this.value=this.value.toUpperCase();',
                        'onFocus' => 'this.value=this.value.toUpperCase();',
                        'onKeyup' => 'this.value=this.value.toUpperCase();'
                    )
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
                'fax',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'glsr.gestock.fax'
                )
            )
            ->add(
                'mail',
                'email',
                array(
                    'trim' => true,
                    'label' => 'glsr.gestock.mail'
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
                'data_class' => 'Glsr\GestockBundle\Entity\Company',
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
        return 'glsr_gestockbundle_company';
    }
}
