<?php
/**
 * InvoicesType Form properties.
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
namespace AppBundle\Form\Type\Orders;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\Orders\OrdersEditType;
use AppBundle\Form\Type\Orders\InvoicesArticlesType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * InvoicesEditType Form properties.
 *
 * @category Form
 */
class InvoicesEditType extends OrdersEditType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('articles');
        $builder->add('articles', CollectionType::class, ['entry_type' => InvoicesArticlesType::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Orders\Orders',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'invoices';
    }
}
