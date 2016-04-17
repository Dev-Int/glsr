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
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Form\Type;

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
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'gestock.name'))
            ->add('address', 'text', array('label' => 'gestock.address'))
            ->add('zipcode', 'text', array('label' => 'gestock.zipcode'))
            ->add('town', 'text', array('label' => 'gestock.town'))
            ->add(
                'phone',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'gestock.phone'
                )
            )
            ->add(
                'fax',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'gestock.fax'
                )
            )
            ->add('mail', 'email', array('label' => 'gestock.mail'))
            ->add('contact', 'text', array('label' => 'gestock.contact'))
            ->add(
                'gsm',
                'tel',
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'label' => 'gestock.gsm'
                )
            )
            // Délai de livraison A = jour de Cmde,
            // (B, C, D, E) = jour de livraison        
            ->add(
                'delaydeliv',
                'choice',
                array(
                    'choices' => array(
                        1 => 'form.atob',
                        2 => 'form.atoc',
                        3 => 'form.atod',
                        4 => 'form.atoe',
                    ),
                    'label' => 'settings.delay',
                    'translation_domain' => 'gs_suppliers'
                )
            )
            // Choix du jour de la semaine pour les Cmdes
            ->add(
                'orderdate',
                'choice',
                array(
                    'choices' => array(
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        7 => 'Sunday',
                    ),
                    'choice_translation_domain' => true,
                    'translation_domain' => 'messages',
                    'label' => 'day_order',
                    'expanded' => true,
                    'multiple' => true,
                )
            )
            ->add(
                'family_log',
                'entity',
                array(
                    'class' => 'AppBundle:FamilyLog',
                    'choice_label' => 'indentedName',
                    'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family',
                    'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog'
                )
            )
            ->add('active', 'hidden');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Supplier',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'supplier';
    }
}
