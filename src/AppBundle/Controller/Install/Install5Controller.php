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
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller\Install;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\Settings\Diverse\FamilyLogType;
use AppBundle\Form\Type\Settings\Diverse\ZoneStorageType;
use AppBundle\Form\Type\Settings\Diverse\UnitType;
use AppBundle\Form\Type\Settings\Diverse\TvaType;

/**
 * class InstallController
 *
 * @category Controller
 *
 * @Route("/install/step5")
 */
class Install5Controller extends InstallController
{
    /**
     * Etape 5.1 de l'installation.
     * Cronfiguration de l'application (Famille logistique).
     *
     * @Route("/1", name="gs_install_st5_1")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step5.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,FamilyLog|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step51Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\FamilyLog',
            '\AppBundle\Entity\Settings\Diverse\FamilyLog',
            FamilyLogType::class,
            '5_1'
        );

        return $return;
    }

    /**
     * Etape 5.2 de l'installation.
     * Cronfiguration de l'application (Zone de stockage).
     *
     * @Route("/2", name="gs_install_st5_2")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step5.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,ZoneStorage|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step52Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\ZoneStorage',
            '\AppBundle\Entity\Settings\Diverse\ZoneStorage',
            ZoneStorageType::class,
            '5_2'
        );

        return $return;
    }

    /**
     * Etape 5.3 de l'installation.
     * Cronfiguration de l'application (Unité de stockage).
     *
     * @Route("/3", name="gs_install_st5_3")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step5.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,UnitStorage|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step53Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\Unit',
            '\AppBundle\Entity\Settings\Diverse\Unit',
            UnitType::class,
            '5_3'
        );

        return $return;
    }

    /**
     * Etape 5.4 de l'installation.
     * Cronfiguration de l'application (Taux de T.V.A.).
     *
     * @Route("/4", name="gs_install_st5_4")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step5.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,Tva|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step54Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\Tva',
            '\AppBundle\Entity\Settings\Diverse\Tva',
            TvaType::class,
            '5_4'
        );

        return $return;
    }
}