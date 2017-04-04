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

use AppBundle\Form\Type\FamilyLogType;
use AppBundle\Form\Type\ZoneStorageType;
use AppBundle\Form\Type\UnitStorageType;
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
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,FamilyLog|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step41Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'FamilyLog',
            '\AppBundle\Entity\FamilyLog',
            FamilyLogType::class,
            '4_1'
        );

        return $return;
    }

    /**
     * Etape 4.2 de l'installation.
     * Cronfiguration de l'application (Zone de stockage).
     *
     * @Route("/2", name="gs_install_st4_2")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step4.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,ZoneStorage|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step42Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'ZoneStorage',
            '\AppBundle\Entity\ZoneStorage',
            ZoneStorageType::class,
            '4_2'
        );

        return $return;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,UnitStorage|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step43Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'UnitStorage',
            '\AppBundle\Entity\UnitStorage',
            UnitStorageType::class,
            '4_3'
        );

        return $return;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,Tva|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step44Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Tva',
            '\AppBundle\Entity\Tva',
            TvaType::class,
            '4_4'
        );

        return $return;
    }
}
