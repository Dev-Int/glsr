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
use Glsr\GestockBundle\Form\Type\FamilyLogType;

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
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $famLog = new FamilyLog();

        $form = $this->createForm(new FamilyLogType(), $famLog);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Ajouter une Familles logistiques.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addProcessAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $famLog = new FamilyLog();

        $form = $this->createForm(new FamilyLogType(), $famLog);

        // On fait le lien Requête <-> Formulaire
        $form->bind($request);

        // On vérifie que les valeurs rentrées sont correctes
        if ($form->isValid()) {
            // On enregistre l'objet $article dans la base de données
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($famLog);
            $etm->flush();

            $message = 'glsr.gestock.settings.add_ok';
            $url = $this->redirect($this->generateUrl('glstock_divers'));
        } else {
            $message = 'glsr.gestock.settings.add_no';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:add.html.twig',
                array(
                    'form' => $form->createView()
                )
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }

    /**
     * Modifier une Familles logistiques.
     *
     * @param FamilyLog $famLog objet Familles logistiques à modifier
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editShowAction(FamilyLog $famLog)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // On utilise le SettingsType
        $form = $this->createForm(new FamilyLogType(), $famLog);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'famlog' => $famLog,
            )
        );
    }

    /**
     * Modifier une Familles logistiques.
     *
     * @param FamilyLog $famLog objet Familles logistiques à modifier.
     * @param Request $request Requète de l'éfition.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editProcessAction(FamilyLog $famLog, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // On utilise le SettingsType
        $form = $this->createForm(new FamilyLogType(), $famLog);

        $form->submit($request);

        if ($form->isValid()) {
            // On enregistre la config
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($famLog);
            $etm->flush();

            $message = 'glsr.gestock.settings.edit_ok';
            $url = $this->redirect($this->generateUrl('glstock_divers'));
        } else {
            $message = 'glsr.gestock.settings.edit_no';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
                array(
                    'form' => $form->createView(),
                    'famlog' => $famLog,
                )
            );
            
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }
}
