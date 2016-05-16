<?php
/**
 * ArticleType Form properties.
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

/**
 * ArticleType Form properties.
 *
 * @category   Form
 */
class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add(
                'name',
                'text',
                array(
                    'label' => 'gestock.title_item',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'packaging',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'settings.packaging',
                    'translation_domain' => 'gs_articles',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'price',
                'money',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'currency' => 'EUR',
                    'label' => 'settings.price',
                    'translation_domain' => 'gs_articles',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add('quantity', 'hidden')
            ->add(
                'minstock',
                'number',
                array(
                    'precision' => 3,
                    'grouping' => true,
                    'label' => 'settings.stock_alert',
                    'translation_domain' => 'gs_articles',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add('active', 'hidden')
            ->add('slug', 'hidden')
            ->add(
                'supplier',
                'entity',
                array(
                    'class' => 'AppBundle:Supplier',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'placeholder' => 'form.choice_supplier',
                    'label' => 'title',
                    'translation_domain' => 'gs_suppliers',
                    'empty_data' => null,
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'unitStorage',
                'entity',
                array(
                    'class' => 'AppBundle:UnitStorage',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'label' => 'gestock.settings.diverse.unitstorage',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'zoneStorage',
                'entity',
                array(
                    'class' => 'AppBundle:ZoneStorage',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'gestock.settings.diverse.zonestorage',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'familyLog',
                'entity',
                array(
                    'class' => 'AppBundle:FamilyLog',
                    'choice_label' => 'indentedName',
                    'multiple' => false,
                    'placeholder' => 'gestock.settings.diverse.choice_family',
                    'empty_data' => null,
                    'label' => 'gestock.settings.diverse.familylog',
                    'attr'  => array('class' => 'form-control')
                )
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'article';
    }
}
