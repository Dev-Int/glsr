<?php

/**
 * ArticleReassignType Form properties.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: f912c90cc23014686059cf730526a2874e826553
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

/**
 * ArticleReassignType Form properties.
 *
 * @category   Form
 */
class ArticleReassignType extends AbstractType
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
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $articles = $event->getData();

                $formOptions = array(
                    'class' => 'GlsrGestockBundle:Supplier',
                    'query_builder' =>
                    function (EntityRepository $er) use ($articles) {
                        return $er->getSupplierForReassign($articles[0]);
                    },
                    'multiple' => false,
                    'empty_data' => null,
                );
                foreach ($articles as $article) {
                    $form->add(
                        'supplier-'.$article->getId(),
                        'entity',
                        $formOptions
                    );
                }
            }
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
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'glsr_gestockbundle_article_reassign';
    }
}
