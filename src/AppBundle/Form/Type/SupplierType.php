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
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;

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
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => 'gestock.name',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'address',
                TextType::class,
                array(
                    'label' => 'gestock.address',
                    'attr'  => array(
                        'placeholder' => 'gestock.address',
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'zipcode',
                TextType::class,
                array(
                    'attr'  => array(
                        'placeholder' => 'gestock.zipcode',
                        'class' => 'form-control half'
                    )
                )
            )
            ->add(
                'town',
                TextType::class,
                array(
                    'attr'  => array(
                        'placeholder' => 'gestock.town',
                        'class' => 'form-control half'
                    )
                )
            )
            ->add(
                'phone',
                PhoneNumberType::class,
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
                    'country_choices' => array('FR', 'GB', 'DE', 'IT'),
                    'preferred_country_choices' => array('FR'),
                    'label' => 'gestock.phone',
                )
            )
            ->add(
                'fax',
                PhoneNumberType::class,
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
                    'country_choices' => array('FR', 'GB', 'DE', 'IT'),
                    'preferred_country_choices' => array('FR'),
                    'label' => 'gestock.fax',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'mail',
                EmailType::class,
                array(
                    'label' => 'gestock.mail',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'contact',
                TextType::class,
                array(
                    'label' => 'gestock.contact',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'gsm',
                PhoneNumberType::class,
                array(
                    'default_region' => 'FR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
                    'country_choices' => array('FR', 'GB', 'DE', 'IT'),
                    'preferred_country_choices' => array('FR'),
                    'label' => 'gestock.gsm',
                    'attr'  => array('class' => 'form-control')
                )
            )
            // Délai de livraison A = jour de Cmde,
            // (B, C, D, E) = jour de livraison
            ->add(
                'delaydeliv',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'form.atob' => 1,
                        'form.atoc' => 2,
                        'form.atod' => 3,
                        'form.atoe' => 4,
                    ),
                    'choices_as_values' => true,
                    'label' => 'settings.delay',
                    'translation_domain' => 'gs_suppliers',
                    'attr'  => array('class' => 'form-control half')
                )
            )
            // Choix du jour de la semaine pour les Cmdes
            ->add(
                'orderdate',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Monday' => 1,
                        'Tuesday' => 2,
                        'Wednesday' => 3,
                        'Thursday' => 4,
                        'Friday' => 5,
                        'Saturday' => 6,
                        'Sunday' => 7,
                    ),
                    'choices_as_values' => true,
                    'choice_translation_domain' => true,
                    'translation_domain' => 'messages',
                    'label' => 'day_order',
                    'attr'  => array('class' => 'form-control'),
                    'expanded' => true,
                    'multiple' => true,
                )
            )
            ->add(
                'familyLog',
                EntityType::class,
                array(
                    'class' => 'AppBundle:FamilyLog',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->orderBy('f.path', 'ASC');
                    },
                    'choice_label' => 'indentedName',
                    'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family',
                    'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog',
                    'attr'  => array('class' => 'form-control half')
                )
            )
            ->add('active', HiddenType::class, array('data' => true));
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
    public function getBlockPrefix()
    {
        return 'supplier';
    }
}
