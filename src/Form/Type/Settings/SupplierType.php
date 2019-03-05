<?php
/**
 * SupplierType Form properties.
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
namespace App\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use libphonenumber\PhoneNumberFormat;
use Doctrine\ORM\EntityRepository;
use App\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;

/**
 * SupplierType Form properties.
 *
 * @category Form
 */
class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'gestock.name', 'attr'  => ['class' => 'form-control',],])
            ->add('address', TextType::class, ['label' => 'gestock.address',
                'attr'  => ['placeholder' => 'gestock.address', 'class' => 'form-control',],])
            ->add('zipcode', TextType::class, ['attr' => ['placeholder' => 'gestock.zipcode',
                'class' => 'form-control half',],])
            ->add('town', TextType::class, ['attr'  => ['placeholder' => 'gestock.town',
                'class' => 'form-control half',],])
            ->add('phone', PhoneNumberType::class, ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 'country_choices' => ['FR', 'GB', 'DE', 'IT',],
                    'preferred_country_choices' => ['FR',], 'label' => 'gestock.phone',])
            ->add('fax', PhoneNumberType::class, ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 'country_choices' => ['FR', 'GB', 'DE', 'IT',],
                    'preferred_country_choices' => ['FR',], 'label' => 'gestock.fax',])
            ->add('mail', EmailType::class, ['label' => 'gestock.mail', 'attr'  => ['class' => 'form-control',]])
            ->add('contact', TextType::class, ['label' => 'gestock.contact', 'attr'  => ['class' => 'form-control',],])
            ->add('gsm', PhoneNumberType::class, ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 'country_choices' => ['FR', 'GB', 'DE', 'IT',],
                    'preferred_country_choices' => ['FR',], 'label' => 'gestock.gsm',])
            /**
             * Delivery time A = day of order, (B, C, D, E) = day of delivery
             */
            ->add('delaydeliv', ChoiceType::class, ['choices' => ['form.atob' => 1, 'form.atoc' => 2,
                'form.atod' => 3, 'form.atoe' => 4,], 'choices_as_values' => true, 'label' => 'settings.delay',
                    'translation_domain' => 'gs_suppliers', 'attr'  => ['class' => 'form-control half',]])
            /**
             * Choice of the day of the week for OrdersChoice of the day of the week for Cmdes
             * Numbering see http://php.net/manual/en/function.date.php format 'N'
             */
            ->add('orderdate', ChoiceType::class, ['choices' => ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3,
                'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7,], 'choices_as_values' => true,
                'choice_translation_domain' => true, 'translation_domain' => 'messages', 'label' => 'day_order',
                'attr'  => ['class' => 'form-control',], 'expanded' => true, 'multiple' => true,])
            ->add('familyLog', EntityType::class, ['class' => 'App:Settings\Diverse\FamilyLog',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->orderBy('f.path', 'ASC');
                    }, 'choice_label' => 'indentedName', 'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family', 'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog', 'attr'  => ['class' => 'form-control half',]])
            ->add('active', HiddenType::class, ['data' => true,])
            ->addEventSubscriber(new AddSaveEditFieldSubscriber())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Settings\Supplier',]);
    }

    public function getBlockPrefix()
    {
        return 'supplier';
    }
}
