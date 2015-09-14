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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
    public function addAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $unitStore = new UnitStorage();

        $form = $this->createForm(new UnitStorageType(), $unitStore);

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->submit($request);

            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {
                // On enregistre l'objet $article dans la base de données
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($unitStore);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.settings.add_ok');

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
     * @param Request $request Requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editAction(UnitStorage $unitStore, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // On utilise le SettingsType
        $form = $this->createForm(new UnitStorageType(), $unitStore);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($unitStore);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.settings.edit_ok');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'unitsotrage' => $unitStore,
            )
        );
    }
}
