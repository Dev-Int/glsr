<?php
/**
 * AddSaveEditFieldSubscriber EventListener.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * AddSaveEditFieldSubscriber EventListener.
 *
 * @category Listener
 */
class AddSaveEditFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data || null === $data->getId()) {
            $form->add(
                'save',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-default btn-primary btn-create'], 'label' => 'Create',
                    'translation_domain' => 'admin', ]
            )
            ->add(
                'addmore',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-default btn-info btn-create'],
                    'label' => 'gestock.settings.form.save&more', ]
            );
        } else {
            $form->add(
                'save',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-default btn-primary btn-edit'], 'label' => 'Edit',
                    'translation_domain' => 'admin', ]
            );
        }
    }
}
