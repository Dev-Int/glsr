<?php
/**
 * SettingsType Form properties.
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

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;

/**
 * SettingsType Form properties.
 *
 * @category   Form
 */
class SettingsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'inventory_style',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'global' => 'gestock.settings.settings.global',
                        'zonestorage' => 'gestock.settings.settings.zone_storage',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'gestock.settings.settings.style_inventory'
                )
            )
            ->add(
                'calculation',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'fifo' => 'gestock.settings.settings.fifo',
                        'weighted' => 'gestock.settings.settings.weighted',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'gestock.settings.settings.calculation'
                )
            )
            ->add(
                'currency',
                CurrencyType::class,
                array(
                    'multiple' => false,
                    'expanded' => false,
                    'preferred_choices' => array('EUR'),
                    'label' => 'gestock.settings.settings.currency'
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Settings',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'application';
    }
}
