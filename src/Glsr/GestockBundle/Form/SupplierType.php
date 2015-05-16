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
namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
            ->add('name', 'text')
            ->add('address', 'text')
            ->add('zipcode', 'text')
            ->add('town', 'text')
            ->add(
                'phone',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                )
            )
            ->add(
                'fax',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                )
            )
            ->add('email', 'email')
            ->add('contact', 'text')
            ->add(
                'gsm',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                )
            )
            // Délai de livraison A = jour de Cmde, (B, C, D, E) = jour de livraison
            ->add(
                'delaydeliv',
                'choice',
                array(
                    'choices' => array(
                        1 => 'A pour B',
                        2 => 'A pour C',
                        3 => 'A pour D',
                        4 => 'A pour E',
                    ),
                )
            )
            // Choix du jour de la semaine pour les Cmdes
            ->add(
                'orderdate',
                'choice',
                array(
                    'choices' => array(
                        1 => 'Lundi',
                        2 => 'Mardi',
                        3 => 'Mercredi',
                        4 => 'Jeudi',
                        5 => 'Vendredi',
                        6 => 'Samedi',
                        7 => 'Dimanche',
                    ),
                    'expanded' => true,
                    'multiple' => true,
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
                    'required' => false,
                    'empty_value' => 'Choice the Sub Family',
                    'empty_data' => null,
                )
            )
            ->add('active', 'hidden');
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
