<?php
/**
 * ArticleReassignType Form properties.
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
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $articles = $event->getData();

                $formOptions = array(
                    'class' => 'AppBundle:Supplier',
                    'query_builder' =>
                    function (EntityRepository $er) use ($articles) {
                        return $er->getSupplierForReassign($articles[0]->getSupplier());
                    },
                    'multiple' => false,
                    'empty_data' => null,
                );
                foreach ($articles as $article) {
                    $form->add(
                        'supplier-'.$article->getId(),
                        EntityType::class,
                        $formOptions
                    );
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'article_reassign';
    }
}
