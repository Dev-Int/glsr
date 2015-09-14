<?php

/**
 * FamilyLogController controller de la configuration des Familles logistiques.
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
use Glsr\GestockBundle\Entity\FamilyLog;
use Glsr\GestockBundle\Form\FamilyLogType;

/**
 * class FamilyLogController.
 *
 * @category   Controller
 */
class FamilyLogController extends Controller
{
    /**
     * Ajouter une Familles logistiques.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $famLog = new FamilyLog();

        $form = $this->createForm(new FamilyLogType(), $famLog);

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
                $etm->persist($famLog);
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
     * Modifier une Familles logistiques.
     *
     * @param FamilyLog $famLog objet Familles logistiques à modifier
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editAction(FamilyLog $famLog, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // On utilise le SettingsType
        $form = $this->createForm(new FamilyLogType(), $famLog);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($famLog);
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
                'tva' => $famLog,
            )
        );
    }
}
