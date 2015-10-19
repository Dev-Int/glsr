<?php

/**
 * SupplierType Form properties.
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

/**
 * SupplierType Form properties.
 *
 * @category   Form
 */
class SupplierDeleteType extends AbstractType
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
        $builder
            ->remove('name')
            ->remove('address')
            ->remove('zipcode')
            ->remove('town')
            ->remove('contact')
            ->remove('gsm')
            ->remove('fax')
            ->remove('phone')
            ->remove('mail')
            ->remove('family_log')
            ->remove('sub_family_log')
            ->remove('delaydeliv')
            ->remove('orderdate')
            ->remove('save')
            ->remove('addmore');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'glsr_gestockbundle_supplier_delete';
    }
    
    /**
     * Returns the name of the parent type.
     *
     * @return \Glsr\GestockBundle\Form\Type\SupplierType The parent of this type
     */
    public function getParent()
    {
        return new SupplierType();
    }
}
