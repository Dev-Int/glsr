<?php
/**
 * InstallController controller d'installation de l'application GLSR.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version   since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller\Install;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FamilyLog;
use AppBundle\Form\Type\FamilyLogType;
use AppBundle\Entity\ZoneStorage;
use AppBundle\Form\Type\ZoneStorageType;
use AppBundle\Entity\UnitStorage;
use AppBundle\Form\Type\UnitStorageType;
use AppBundle\Entity\Tva;
use AppBundle\Form\Type\TvaType;

/**
 * class InstallController
 *
 * @category Controller
 *
 * @Route("/install/step4")
 */
class Install4Controller extends InstallController
{
    /**
     * Etape 4.1 de l'installation.
     * Cronfiguration de l'application (Famille logistique).
     *
     * @Route("/1", name="gs_install_st4_1")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step4.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array,FamilyLog|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step41Action(Request $request)
    {
        $familylog = new FamilyLog();
        $form = $this->createForm(new FamilyLogType(), $familylog, array(
            'action' => $this->generateUrl('gs_install_st4_1')
        ));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familylog);
            $em->flush();

            if ($form->get('save')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4'));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4_1'));
            }
            $this->addFlash('info', 'gestock.settings.add_ok');

            return $url;
        }

        return array(
            'familylog' => $familylog,
            'form'   => $form->createView(),
        );
    }

    /**
     * Etape 4.2 de l'installation.
     * Cronfiguration de l'application (Zone de stockage).
     *
     * @Route("/2", name="gs_install_st4_2")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step4.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return Symfony\Component\HttpFoundation\Response Rendue de la page
     */
    public function step42Action(Request $request)
    {
        $zoneStorage = new ZoneStorage();
        $form = $this->createForm(new ZoneStorageType(), $zoneStorage, array(
            'action' => $this->generateUrl('gs_install_st4_2')
        ));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zoneStorage);
            $em->flush();
            $this->addFlash('info', 'gestock.settings.add_ok');

            if ($form->get('save')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4'));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4_2'));
            }
            return $url;
        }

        return array('zonestorage' => $zoneStorage, 'form' => $form->createView());
    }

    /**
     * Etape 4.3 de l'installation.
     * Cronfiguration de l'application (Unité de stockage).
     *
     * @Route("/3", name="gs_install_st4_3")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step4.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array,UnitStorage|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step43Action(Request $request)
    {
        $unitStorage = new UnitStorage();
        $form = $this->createForm(new UnitStorageType(), $unitStorage, array(
            'action' => $this->generateUrl('gs_install_st4_3')
        ));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unitStorage);
            $em->flush();
            $this->addFlash('info', 'gestock.settings.add_ok');

            if ($form->get('save')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4'));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4_3'));
            }
            return $url;
        }

        return array('unitstorage' => $unitStorage, 'form' => $form->createView());
    }

    /**
     * Etape 4.4 de l'installation.
     * Cronfiguration de l'application (Taux de T.V.A.).
     *
     * @Route("/4", name="gs_install_st4_4")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step4.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array,Tva|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step44Action(Request $request)
    {
        $tva = new Tva();
        $form = $this->createForm(new TvaType(), $tva, array(
            'action' => $this->generateUrl('gs_install_st4_4')
        ));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tva);
            $em->flush();
            $this->addFlash('info', 'gestock.settings.add_ok');

            if ($form->get('save')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4'));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $url = $this->redirect($this->generateUrl('gs_install_st4_4'));
            }
            return $url;
        }

        return array('tva' => $tva, 'form' => $form->createView());
    }
}
