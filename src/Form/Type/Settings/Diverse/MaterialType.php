<?php

/**
 * MaterialType Form properties.
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
use Doctrine\ORM\EntityRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * MaterialType Form properties.
 *
 * @category Form
 */
class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'gestock.name', 'attr'  => ['class' => 'half'],])
            ->add('unitWorking', EntityType::class, ['class' => 'App:Settings\Diverse\Unit',
                'choice_label' => 'name', 'multiple' => false, 'label' => 'gestock.settings.diverse.unitworking',
                'attr'  => ['class' => 'half',],])
            ->add('active', CheckboxType::class, ['required' => false, 'label' => 'gestock.actif',])
            ->add('multiple', CheckboxType::class, ['required' => false, 'label' => 'gestock.multiple',])
            ->add('articles', EntityType::class, ['class' => 'App:Settings\Article',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')->orderBy('a.name', 'ASC');
                    }, 'choice_label' => 'name', 'multiple' => true, 'expanded' => true, 'label' => 'title',
                        'translation_domain' => 'gs_articles',])
            ->addEventSubscriber(new AddSaveEditFieldSubscriber())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => 'App\Entity\Settings\Diverse\Material',]
        );
    }

    public function getBlockPrefix()
    {
        return 'material';
    }
}
