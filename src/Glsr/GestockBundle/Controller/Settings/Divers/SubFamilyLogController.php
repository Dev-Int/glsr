<?php

/**
 * SubFamilyLogController controller
 *   de la configuration des Sous-familles logistiques.
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
use Glsr\GestockBundle\Entity\SubFamilyLog;
use Glsr\GestockBundle\Form\Type\SubFamilyLogType;

/**
 * class SubFamilyLogController.
 *
 * @category   Controller
 */
class SubFamilyLogController extends Controller
{
    /**
     * Ajouter une Sous-familles logistiques.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $famLog = new SubFamilyLog();

        $form = $this->createForm(new SubFamilyLogType(), $famLog);
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
     * Ajouter une Sous-familles logistiques.
     *
     * @param Request $request Requète de l'ajout.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addProcessAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $famLog = new SubFamilyLog();

        $form = $this->createForm(new SubFamilyLogType(), $famLog);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($famLog);
            $etm->flush();

            if ($form->get('save')->isClicked()) {
                $url = $this->redirect($this->generateUrl('glstock_home'));
            } elseif ($form->get('addmore')->isClicked()) {
                $url = $this->redirect(
                    $this->generateUrl('glstock_setdiv_subfamlog_add')
                );
            }
            $message = 'glsr.gestock.settings.add_ok';
        } else {
            $message = 'glsr.gestock.settings.add_no';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:add.html.twig',
                array(
                    'form' => $form->createView(),
                )
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }

    /**
     * Modifier une Sous-familles logistiques.
     *
     * @param SubFamilyLog $subFam objet Familles logistiques à modifier.
     * @param Request $request Requète de la modification.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editShowAction(SubFamilyLog $subFam, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new SubFamilyLogType(), $subFam);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'subfamlog' => $subFam,
            )
        );
    }

    /**
     * Modifier une Sous-familles logistiques.
     *
     * @param SubFamilyLog $subFam  Familles logistiques à modifier.
     * @param Request      $request Requète de la modification.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editProcessAction(SubFamilyLog $subFam, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new SubFamilyLogType(), $subFam);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($subFam);
            $etm->flush();

            $message = 'glsr.gestock.settings.edit_ok';
            $url = $this->redirect($this->generateUrl('glstock_divers'));
        } else {
            $message = 'glsr.gestock.settings.edit_no';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
                array(
                    'form' => $form->createView(),
                    'subfamlog' => $subFam,
                )
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }

    /**
     * Supprimer une Sous-familles logistiques.
     *
     * @param SubFamilyLog $subFam objet Familles logistiques à supprimer.
     * @param Request $request Requète de la suppression.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteShowAction(SubFamilyLog $subFam)
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
            $form = $this->createForm(new SubFamilyLogType(), $subFam);

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
     * Supprimer une Sous-familles logistiques.
     *
     * @param SubFamilyLog $subFam  Familles logistiques à supprimer.
     * @param Request      $request Requète de la suppression.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcessAction(SubFamilyLog $subFam, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new SubFamilyLogType(), $subFam);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($subFam);
            $etm->flush();

            $message = 'glsr.gestock.settings.diverse.delete.ok';
            $url = $this->generateUrl('glstock_divers');
        } else {
            $message = 'glsr.gestock.settings.diverse.delete.no';
            $url = $this->generateUrl('glstock_setdiv_subfamlog_del');
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $this->redirect($url);
    }
}
