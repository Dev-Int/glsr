<?php
/**
 * UnitStorageType Form properties.
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
namespace App\Form\Type\Settings\Diverse;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * UnitStorageType Form properties.
 *
 * @category Form
 */
class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'gestock.settings.diverse.unitstorage',
                'attr' => ['class' => 'half',],])
            ->add('abbr', TextType::class, ['label' => 'gestock.abbr', 'attr' => ['class' => 'half',],])
            ->addEventSubscriber(new AddSaveEditFieldSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Settings\Diverse\Unit',]);
    }

    public function getBlockPrefix()
    {
        return 'unit';
    }
}
