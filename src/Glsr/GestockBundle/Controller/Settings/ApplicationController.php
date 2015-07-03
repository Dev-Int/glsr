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
use Glsr\GestockBundle\Entity\Settings;
use Glsr\GestockBundle\Form\SettingsType;

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
     * @return Response
     */
    public function showAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $repoSettings = $etm->getRepository('GlsrGestockBundle:Settings');
        $settings = $repoSettings->findAll();

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
    public function addAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add(
                    'info',
                    'Vous devez être connecté pour accéder à cette page.'
                );

            // On redirige vers la page de connexion
            return $this->redirect(
                $this->generateUrl(
                    'fos_user_security_login'
                )
            );
        }
        $settings = new Settings();

        $form = $this->createForm(new SettingsType(), $settings);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {
                // On enregistre l'objet $article dans la base de données
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($settings);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Configuration bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect(
                    $this->generateUrl(
                        'glstock_application'
                    )
                );
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Modifier les paramètres de base de l'application.
     *
     * @param Settings $settings
     * Objet de l'entité Settings à modifier
     *
     * @return Response
     */
    public function editAction(Settings $settings)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add(
                    'info',
                    'Vous devez être connecté pour accéder à cette page.'
                );

            // On redirige vers la page de connexion
            return $this->redirect(
                $this->generateUrl(
                    'fos_user_security_login'
                )
            );
        }
        // On utilise le SettingsType
        $form = $this->createForm(new SettingsType(), $settings);

        $request = $this->getRequest();

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
                    ->add('info', 'Configuration bien modifié');

                return $this->redirect(
                    $this->generateUrl(
                        'glstock_application'
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
