<?php
/**
 * Install5Controller Step 5 installation controller of the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace App\Controller\Install;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use App\Form\Type\Settings\Diverse\FamilyLogType;
use App\Form\Type\Settings\Diverse\ZoneStorageType;
use App\Form\Type\Settings\Diverse\UnitType;
use App\Form\Type\Settings\Diverse\TvaType;

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
     * Step 5.1 of the installation.
     * Configuration of the application (Logistic family).
     *
     * @Route("/1", name="gs_install_st5_1")
     * @Method({"POST","GET"})
     * @Template("install/step5.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,FamilyLog|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step51Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\FamilyLog',
            '\App\Entity\Settings\Diverse\FamilyLog',
            FamilyLogType::class,
            '5_1'
        );

        return $return;
    }

    /**
     * Step 5.2 of the installation.
     * Configuration of the application (storage area).
     *
     * @Route("/2", name="gs_install_st5_2")
     * @Method({"POST","GET"})
     * @Template("install/step5.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,ZoneStorage|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step52Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\ZoneStorage',
            '\App\Entity\Settings\Diverse\ZoneStorage',
            ZoneStorageType::class,
            '5_2'
        );

        return $return;
    }

    /**
     * Step 5.3 of the installation.
     * Configuration of the application (Storage unit).
     *
     * @Route("/3", name="gs_install_st5_3")
     * @Method({"POST","GET"})
     * @Template("install/step5.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,UnitStorage|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step53Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\Unit',
            '\App\Entity\Settings\Diverse\Unit',
            UnitType::class,
            '5_3'
        );

        return $return;
    }

    /**
     * Step 5.4 of the installation.
     * Configuration of the application (VAT rate.).
     *
     * @Route("/4", name="gs_install_st5_4")
     * @Method({"POST","GET"})
     * @Template("install/step5.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|string|array
     * <string,Tva|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step54Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\Tva',
            '\App\Entity\Settings\Diverse\Tva',
            TvaType::class,
            '5_4'
        );

        return $return;
    }
}
