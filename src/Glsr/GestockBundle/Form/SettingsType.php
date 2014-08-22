<?php

/**
 * SettingsType Form properties
 * 
 * PHP Version 5
 * 
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: 66c30ad5658ae2ccc5f74e6258fa4716d852caf9
 * @link       https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;

\locale::setDefault('en');
$currency = Intl::getCurrencyBundle()->getCurrencyName('EUR');

/**
 * SettingsType Form properties
 * 
 * @category   Form
 * @package    Gestock
 * @subpackage Settings
 */
class SettingsType extends AbstractType
{
    /**
     * buildForm
     * 
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     * 
     * @return Form                $form    Formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'inventory_style',
                'choice',
                array(
                    'choices' => array(
                        'global' => 'Global',
                        'zonestorage' => 'Zone Storage'
                    ),
                    'expanded' => true,
                    'multiple' => false,
                )
            )
            ->add(
                'calculation',
                'choice',
                array(
                    'choices' => array(
                        'fifo' => 'FIFO',
                        'weighted' => 'weighted'
                    ),
                    'expanded' => true,
                    'multiple' => false,
                )
            )
            ->add('first_inventory', 'hidden')
            ->add(
                'currency',
                'currency',
                array(
                    'multiple'         => false,
                    'expanded'         => false,
                    'preferred_choices' => array('EUR')
                )
            );
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
                'data_class' => 'Glsr\GestockBundle\Entity\Settings'
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
