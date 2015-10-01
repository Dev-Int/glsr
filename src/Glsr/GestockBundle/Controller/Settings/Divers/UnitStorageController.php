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
use Glsr\GestockBundle\Form\Type\UnitStorageType;

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
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $unitStore = new UnitStorage();

        $form = $this->createForm(new UnitStorageType(), $unitStore);
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
     * Ajouter une Unités de stockage.
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
        $unitStore = new UnitStorage();

        $form = $this->createForm(new UnitStorageType(), $unitStore);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($unitStore);
            $etm->flush();

            $message = 'glsr.gestock.settings.add_ok';
            $url = $this->redirect($this->generateUrl('glstock_divers'));
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
     * Modifier une Unités de stockage.
     *
     * @param UnitStorage $unitStore Unités de stockage à modifier.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editShowAction(UnitStorage $unitStore)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new UnitStorageType(), $unitStore);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'unitsotrage' => $unitStore,
            )
        );
    }

    /**
     * Modifier une Unités de stockage.
     *
     * @param UnitStorage $unitStore Unités de stockage à modifier.
     * @param Request $request Requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editProcessAction(UnitStorage $unitStore, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new UnitStorageType(), $unitStore);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($unitStore);
            $etm->flush();

            $message = 'glsr.gestock.settings.edit_ok';
            $url = $this->redirect($this->generateUrl('glstock_divers'));
        } else {
            $message = 'glsr.gestock.settings.edit_no';
            $url =$this->render(
                'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
                array(
                    'form' => $form->createView(),
                    'unitsotrage' => $unitStore,
                )
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }

    /**
     * Supprimer une Unités de stockage.
     *
     * @param UnitStorage $unitStore Unité de stockage à supprimer.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteShowAction(UnitStorage $unitStore)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $etm = $this->getDoctrine()->getManager();
        $article = $etm->getRepository('GlsrGestockBundle:Article')
            ->findAll();
        if (!empty($article)) {
            $message = 'glsr.gestock.settings.diverse.delete.forbidden';
            $url = $this->redirect($this->generateUrl('glstock_home'));
        } else {
            $form = $this->createForm(new UnitStorageType(), $unitStore);

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
     * Supprimer une Unités de stockage.
     *
     * @param UnitStorage $unitStore Unités de stockage à supprimer.
     * @param Request $request Requète de l'édition.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcessAction(UnitStorage $unitStore, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new UnitStorageType(), $unitStore);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($unitStore);
            $etm->flush();

            $message = 'glsr.gestock.settings.diverse.delete.ok';
            $url = $this->generateUrl('glstock_divers');
        } else {
            $message = 'glsr.gestock.settings.diverse.delete.no';
            $url = $this->generateUrl(
                'glstock_setdiv_unitstorage_del',
                array('id' => $unitStore->getId())
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $this->redirect($url);
    }
}
