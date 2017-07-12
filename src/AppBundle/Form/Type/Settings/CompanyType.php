<?php
/**
 * CompanyType Form properties.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use libphonenumber\PhoneNumberFormat;
use AppBundle\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;

/**
 * CompanyType Form properties.
 *
 * @category Form
 */
class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'gestock.settings.company.name',])
            ->add('status', TextType::class, ['label' => 'gestock.settings.company.status',])
            ->add('address', TextType::class, ['label' => 'gestock.address',])
            ->add('zipcode', TextType::class, ['label' => 'gestock.zipcode',])
            ->add('town', TextType::class, ['label' => 'gestock.town', 'attr' => [
                'onBlur' => 'this.value=this.value.toUpperCase();',
                'onFocus' => 'this.value=this.value.toUpperCase();',
                'onKeyup' => 'this.value=this.value.toUpperCase();',]])
            ->add('phone', PhoneNumberType::class, ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 'country_choices' => ['FR', 'GB', 'DE', 'IT',],
                    'preferred_country_choices' => ['FR',], 'label' => 'gestock.phone',])
            ->add('fax', PhoneNumberType::class, ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 'country_choices' => ['FR', 'GB', 'DE', 'IT',],
                    'preferred_country_choices' => ['FR',], 'label' => 'gestock.fax',])
            ->add('mail', EmailType::class, ['trim' => true, 'label' => 'gestock.mail',])
            ->add('contact', TextType::class, ['label' => 'gestock.contact',])
            ->add('gsm', PhoneNumberType::class, ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                    'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 'country_choices' => ['FR', 'GB', 'DE', 'IT',],
                    'preferred_country_choices' => ['FR',], 'label' => 'gestock.gsm',])
            ->addEventSubscriber(new AddSaveEditFieldSubscriber())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Settings\Company',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'company';
    }
}
