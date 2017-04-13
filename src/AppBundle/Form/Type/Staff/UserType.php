<?php
/**
 * UserType Form properties.
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
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * UserType Form properties.
 *
 * @category Form
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('username', null, ['label' => "Nom d'utilisateur", 'attr'  => ['class' => 'form-control'],])
            ->add('email', EmailType::class, array(
                'required' => false,
                'label' => 'E-mail',
                'attr'  => ['class' => 'form-control'],
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'required' => $options['passwordRequired'],
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Répétez le mot de passe'),
                'attr'  => array('class' => 'form-control'),
            ))
            ->add('groups', EntityType::class, array(
                'class' => 'AppBundle:Group',
                'label' => 'Groupes',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ))
        ;
        if ($options['lockedRequired']) {
            $builder->add('enabled', null, array('required' => false,
                'label' => 'Activer le compte'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'passwordRequired' => true,
            'lockedRequired' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user';
    }
}
