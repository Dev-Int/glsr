<?php

/**
 * UnitStorageController controller de la configuration des Unités de stockage.
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
namespace Glsr\GestockBundle\Controller\Settings\Divers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\UnitStorage;
use Glsr\GestockBundle\Form\UnitStorageType;

/**
 * class UnitStorageController.
 *
 * @category   Controller
 */
class UnitStorageController extends Controller
{
    /**
     * Ajouter une Unités de stockage.
     *
     * @return Symfony\Component\HttpFoundation\Response
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
        $unitStore = new UnitStorage();

        $form = $this->createForm(new UnitStorageType(), $unitStore);

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
                $etm->persist($unitStore);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Unités de stockage bien ajoutée');

                // On redirige vers la page de visualisation des
                // configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_divers'));
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
     * Modifier une Unités de stockage.
     *
     * @param UnitStorage $unitStore objet Familles logistiques à modifier
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editAction(UnitStorage $unitStore)
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
        $form = $this->createForm(new UnitStorageType(), $unitStore);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($unitStore);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Famille bien modifié');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'tva' => $unitStore,
            )
        );
    }
}
