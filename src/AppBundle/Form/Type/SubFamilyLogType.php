<?php
/**
 * SubFamilyLogType Form properties.
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

use AppBundle\Form\EventListener\AddSaveEditFieldSubscriber;

/**
 * SubFamilyLogType Form properties.
 *
 * @category   Form
 */
class SubFamilyLogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('name', 'text', array('label' => 'gestock.settings.diverse.subfamily'))
            ->add('slug', 'hidden')
            ->add(
                'familylogs',
                'entity',
                array(
                    'class' => 'AppBundle:FamilyLog',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'label' => 'gestock.settings.diverse.family'
                )
            )
            ->addEventSubscriber(new AddSaveEditFieldSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SubFamilyLog',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'subfamilylog';
    }
}
