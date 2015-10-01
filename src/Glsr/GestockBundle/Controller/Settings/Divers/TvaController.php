<?php

/**
 * TvaController controller de la configuration des Taxes.
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
use Glsr\GestockBundle\Entity\Tva;
use Glsr\GestockBundle\Form\Type\TvaType;

/**
 * class TvaController.
 *
 * @category   Controller
 */
class TvaController extends Controller
{
    /**
     * Ajouter une TVA.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $tva = new Tva();

        $form = $this->createForm(new TvaType(), $tva);
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
     * Ajouter une TVA.
     *
     * @param Request $request Requètede l'ajout.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function addProcessAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $tva = new Tva();

        $form = $this->createForm(new TvaType(), $tva);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($tva);
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
     * Modifier une TVA.
     *
     * @param Tva $tva objet TVA à modifier
     * @param Request $request objet requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editShowAction(Tva $tva, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new TvaType(), $tva);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'tva' => $tva,
            )
        );
    }

    /**
     * Modifier une TVA.
     *
     * @param Tva $tva objet TVA à modifier
     * @param Request $request objet requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function editProcessAction(Tva $tva, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new TvaType(), $tva);

        $form->bind($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($tva);
            $etm->flush();

            $message = 'glsr.gestock.settings.edit_ok';
            $url = $this->redirect($this->generateUrl('glstock_divers'));
        } else {
            $message = 'glsr.gestock.settings.edit_no';
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
                array(
                    'form' => $form->createView(),
                    'tva' => $tva,
                )
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $url;
    }

    /**
     * Supprimer une Tva.
     *
     * @param Tva $tva Tva à supprimer.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteShowAction(Tva $tva)
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
            $form = $this->createForm(new TvaType(), $tva);

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
     * Supprimer une Tva.
     *
     * @param Tva $tva Tva à supprimer.
     * @param Request $request Requète de la suppression.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcessAction(Tva $tva, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new TvaType(), $tva);

        $form->submit($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($tva);
            $etm->flush();

            $message = 'glsr.gestock.settings.diverse.delete.ok';
            $url = $this->generateUrl('glstock_divers');
        } else {
            $message = 'glsr.gestock.settings.diverse.delete.no';
            $url = $this->generateUrl(
                'glstock_setdiv_tva_del',
                array('id' => $tva->getId())
            );
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $this->redirect($url);
    }
}
