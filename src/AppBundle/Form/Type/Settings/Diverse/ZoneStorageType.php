<?php
/**
 * ZoneStorageType Form properties.
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
namespace AppBundle\Form\Type\Settings\Diverse;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\EventListener\AddSaveEditFieldSubscriber;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * ZoneStorageType Form properties.
 *
 * @category Form
 */
class ZoneStorageType extends AbstractType
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
                array('label' => 'gestock.settings.diverse.zonestorage')
            )
            ->addEventSubscriber(new AddSaveEditFieldSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Settings\Diverse\ZoneStorage',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'zonestorage';
    }
}
