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
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
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
        $message = 'glsr.gestock.settings.new_caution';
        $this->get('session')->getFlashBag()->add('danger', $message);

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

            if ($form->get('save')->isClicked()) {
                $url = $this->redirect($this->generateUrl('glstock_home'));
            } elseif ($form->get('addmore')->isClicked()) {
                $url = $this->redirect(
                    $this->generateUrl('glstock_setdiv_famlog_add')
                );
            }
            $message = 'glsr.gestock.settings.add_ok';
        } else {
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:add.html.twig',
                array(
                    'form' => $form->createView()
                )
            );
            $message = 'glsr.gestock.settings.add_no';
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

        $form->handleRequest($request);

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

    /**
     * Supprimer une Familles logistiques.
     *
     * @param FamilyLog $famLog objet Familles logistiques à supprimer.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteShowAction(FamilyLog $famLog)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $etm = $this->getDoctrine()->getManager();
        $supplier = $etm->getRepository('GlsrGestockBundle:Supplier')
            ->findAll();
        if (!empty($supplier)) {
            $message = 'glsr.gestock.settings.diverse.delete.forbidden';
            $url = $this->redirect($this->generateUrl('glstock_home'));
        } else {
            $form = $this->createForm(new FamilyLogType(), $famLog);

            $message = 'glsr.gestock.settings.diverse.delete.caution';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:delete.html.twig',
                array('form' => $form->createView())
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }

    /**
     * Supprimer une Familles logistiques.
     *
     * @param FamilyLog $famLog objet Familles logistiques à supprimer.
     * @param Request $request Requète de l'édition.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcessAction(FamilyLog $famLog, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new FamilyLogType(), $famLog);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($famLog);
            $etm->flush();

            $message = 'glsr.gestock.settings.diverse.delete.ok';
            $url = $this->generateUrl('glstock_divers');
        } else {
            $message = 'glsr.gestock.settings.diverse.delete.no';
            $url = $this->generateUrl(
                'glstock_setdiv_famlog_del',
                array('id' => $famLog->getId())
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $this->redirect($url);
    }
}
