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
}
