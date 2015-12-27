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
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace Glsr\GestockBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * SettingsType Form properties.
 *
 * @category   Form
 */
class SettingsType extends AbstractType
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
                'inventory_style',
                'choice',
                array(
                    'choices' => array(
                        'global' => 'glsr.gestock.settings.application.global',
                        'zonestorage' => 'glsr.gestock.settings.application.zone_storage',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'glsr.gestock.settings.application.style_inventory'
                )
            )
            ->add(
                'calculation',
                'choice',
                array(
                    'choices' => array(
                        'fifo' => 'glsr.gestock.settings.application.fifo',
                        'weighted' => 'glsr.gestock.settings.application.weighted',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'glsr.gestock.settings.application.calculation'
                )
            )
//            ->add('first_inventory', 'hidden')
            ->add(
                'currency',
                'currency',
                array(
                    'multiple' => false,
                    'expanded' => false,
                    'preferred_choices' => array('EUR'),
                    'label' => 'glsr.gestock.settings.application.currency'
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
                'data_class' => 'Glsr\GestockBundle\Entity\Settings',
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
        return 'glsr_gestockbundle_settings';
    }
}
