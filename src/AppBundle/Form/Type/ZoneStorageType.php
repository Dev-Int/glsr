<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneStorageType extends AbstractType
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
                array('label' => 'gestock.settings.diverse.zonestorage')
            )
            ->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary'
                    ),
                    'label' => 'gestock.settings.form.save'
                )
            )
            ->add(
                'addmore',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary'
                    ),
                    'label' => 'gestock.settings.form.save&more'
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ZoneStorage',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zonestorage';
    }
}
