<?php

/**
 * ApplicationController controller de la configuration de l'application.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Glsr\GestockBundle\Entity\Settings;
use Glsr\GestockBundle\Form\Type\SettingsType;

/**
 * class ApplicationController.
 *
 * @category   Controller
 */
class ApplicationController extends Controller
{
    /**
     * Affiche les paramètres de base de l'application.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $settings = $etm
            ->getRepository('GlsrGestockBundle:Settings')
            ->findAll();

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:index.html.twig',
            array('settings' => $settings)
        );
    }

    /**
     * Ajouter un paramètre à l'application.
     *
     * @return Response
     */
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $etm = $this->getDoctrine()->getManager();
        $testApp = $etm
            ->getRepository('GlsrGestockBundle:Settings')
            ->findAll();
        if (count($testApp) >= 1) {
            $url = $this->redirect($this->generateUrl('glstock_home'));
            $message = "glsr.gestock.settings.application.add2";
            $this->get('session')->getFlashBag()->add('info', $message);
        } else {
            $settings = new Settings();

            $form = $this->createForm(new SettingsType(), $settings);

            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:add.html.twig',
                array(
                    'form' => $form->createView(),
                )
            );
        }
        return $url;
    }

    /**
     * Ajouter un paramètre à l'application.
     *
     * @return Symfony\Component\HttpFoundation\Response
     * @todo Ajouter redirection settings_add.
     */
    public function addProcessAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $settings = new Settings();

        $form = $this->createForm(new SettingsType(), $settings);

        // On fait le lien Requête <-> Formulaire
        $form->submit($request);

        // On vérifie que les valeurs rentrées sont correctes
        if ($form->isValid()) {
            // On enregistre l'objet $article dans la base de données
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($settings);
            $etm->flush();

            $message = 'glsr.gestock.settings.add_ok';

            $url = $this->generateUrl('glstock_home');
        } else {
            $message = 'glsr.gestock.settings.add_no';

            $url = $this->generateUrl('glstock_application_add');
        }

        $this->get('session')->getFlashBag()->add('info', $message);

        return $this->redirect($url);
    }

    /**
     * Modifier les paramètres de base de l'application.
     *
     * @param Settings $settings
     * Objet de l'entité Settings à modifier
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Settings $settings, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // On utilise le SettingsType
        $form = $this->createForm(new SettingsType(), $settings);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($settings);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.settings.edit_ok');

                return $this->redirect(
                    $this->generateUrl(
                        'glstock_application_show'
                    )
                );
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
            'form' => $form->createView(),
            'settings' => $settings,
            )
        );
    }
}
