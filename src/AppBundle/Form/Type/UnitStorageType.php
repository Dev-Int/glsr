<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Form\EventListener\AddSaveEditFieldSubscriber;

class UnitStorageType extends AbstractType
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
                array('label' => 'gestock.settings.diverse.unitstorage')
            )
            ->add('abbr', 'text', array('label' => 'gestock.abbr'))
            ->addEventSubscriber(new AddSaveEditFieldSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UnitStorage',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'unitstorage';
    }
}
