<?php

namespace Glsr\GestockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

/**
 * ArticleReassign Form properties
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
 
                $formOptions = array(
                    'class'         => 'GlsrGestockBundle:Supplier',
                    'query_builder' => function (EntityRepository $er) use ($articles) {
                        return $er->getSupplierForReassign($articles[0]); 
                    },
                    'multiple'   => false,
                    'empty_data' => null
                );
                foreach ($articles as $article) {
                    $form->add('supplier-' . $article->getId(), 'entity', $formOptions);
                }
            }
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'glsr_gestockbundle_article_reassign';
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Glsr\GestockBundle\Entity\Article'
//        ));
    }
}
