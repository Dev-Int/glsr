<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddSaveEditFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data || null === $data->getId()) {
            $form->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary btn-create'
                    ),
                    'label' => 'Create',
                    'translation_domain' => 'admin'
                )
            )
            ->add(
                'addmore',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary btn-create'
                    ),
                    'label' => 'gestock.settings.form.save&more'
                )
            );
        } else {
            $form->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-default btn-primary btn-edit'
                    ),
                    'label' => 'Edit',
                    'translation_domain' => 'admin'
                )
            );
        }
    }
}
