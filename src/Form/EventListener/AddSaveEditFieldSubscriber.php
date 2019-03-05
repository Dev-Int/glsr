<?php
/**
 * AddSaveEditFieldSubscriber EventListener.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * AddSaveEditFieldSubscriber EventListener.
 *  When you create a new entity, you can create just one, or one and more...
 *  So, this subscriber creates a button to register just one or more entities.
 *
 * @category Listener
 */
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
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-default btn-primary btn-create',], 'label' => 'Create',
                    'translation_domain' => 'admin',]
            )
            ->add(
                'addmore',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-default btn-info btn-create'],
                    'label' => 'gestock.settings.form.save&more']
            );
        } else {
            $form->add(
                'save',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-default btn-primary btn-edit',], 'label' => 'Edit',
                    'translation_domain' => 'admin',]
            );
        }
    }
}
