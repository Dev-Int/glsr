<?php

/**
 * ZoneStorageController controller de la configuration des Zones de stockage.
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
use Glsr\GestockBundle\Entity\ZoneStorage;
use Glsr\GestockBundle\Form\Type\ZoneStorageType;

/**
 * class ZoneStorageController.
 *
 * @category   Controller
 */
class ZoneStorageController extends Controller
{
    /**
     * Ajouter une Zones de stockage.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $zoneStore = new ZoneStorage();

        $form = $this->createForm(new ZoneStorageType(), $zoneStore);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Ajouter une Zones de stockage.
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
        $zoneStore = new ZoneStorage();

        $form = $this->createForm(new ZoneStorageType(), $zoneStore);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($zoneStore);
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
     * Modifier une Zones de stockage.
     *
     * @param ZoneStorage $zoneStore objet Zones de stockage à modifier.
     * @param Request $request Requète de la modification.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editShowAction(ZoneStorage $zoneStore, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new ZoneStorageType(), $zoneStore);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'zonestorage' => $zoneStore,
            )
        );
    }

    /**
     * Modifier une Zones de stockage.
     *
     * @param ZoneStorage $zoneStore objet Zones de stockage à modifier.
     * @param Request $request Requète de la modification.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editProcessAction(ZoneStorage $zoneStore, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new ZoneStorageType(), $zoneStore);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($zoneStore);
            $etm->flush();

            $message = 'glsr.gestock.settings.edit_ok';

            $url = $this->redirect($this->generateUrl('glstock_divers'));
        } else {
            $message = 'glsr.gestock.settings.edit_ok';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
                array(
                    'form' => $form->createView(),
                    'zonestorage' => $zoneStore,
                )
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);

        return $url;
    }
}
