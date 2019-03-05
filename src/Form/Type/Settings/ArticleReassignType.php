<?php
/**
 * ArticleReassignType Form properties.
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * ArticleReassignType Form properties.
 *
 * @category Form
 */
class ArticleReassignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $articles = $event->getData();

                $formOptions = ['class' => 'App:Settings\Supplier', 'query_builder' =>
                    function (EntityRepository $er) use ($articles) {
                        return $er->getSupplierForReassign($articles[0]->getSupplier());
                    }, 'multiple' => false, 'empty_data' => null,];
                foreach ($articles as $article) {
                    $form->add('supplier-'.$article->getId(), EntityType::class, $formOptions);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'article_reassign';
    }
}
