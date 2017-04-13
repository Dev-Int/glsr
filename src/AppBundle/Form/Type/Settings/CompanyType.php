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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

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
            ->add('phone', 'tel', ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'gestock.phone',])
            ->add('fax', 'tel', ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'gestock.fax',])
            ->add('mail', EmailType::class, ['trim' => true, 'label' => 'gestock.mail',])
            ->add('contact', TextType::class, ['label' => 'gestock.contact',])
            ->add('gsm', 'tel', ['default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'gestock.gsm']);
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
