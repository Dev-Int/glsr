<?php
/**
 * SettingsType Form properties.
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

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use App\Form\EventListener\AddSaveEditFieldSubscriber;

/**
 * SettingsType Form properties.
 *
 * @category Form
 */
class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inventory_style', ChoiceType::class, ['choices' => ['gestock.settings.settings.global' => 'global',
                'gestock.settings.settings.zone_storage' => 'zonestorage',], 'choices_as_values' => true,
                'expanded' => true, 'multiple' => false,
                'label' => 'gestock.settings.settings.style_inventory',])
            ->add('calculation', ChoiceType::class, ['choices' => ['gestock.settings.settings.fifo' => 'fifo',
                'gestock.settings.settings.weighted' => 'weighted',], 'choices_as_values' => true,
                'expanded' => true, 'multiple' => false,
                'label' => 'gestock.settings.settings.calculation',])
            ->add('currency', CurrencyType::class, ['multiple' => false, 'expanded' => false,
                'preferred_choices' => ['EUR'], 'label' => 'gestock.settings.settings.currency',])
            ->addEventSubscriber(new AddSaveEditFieldSubscriber())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Settings\Settings',
        ));
    }

    public function getBlockPrefix()
    {
        return 'application';
    }
}
