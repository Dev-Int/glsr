<?php

/**
 * DiversController controller de la configuration du Bundle Gestock.
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
namespace Glsr\GestockBundle\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * class SettingsController.
 *
 * @category   Controller
 */
class DiversController extends Controller
{
    /**
     * Affiche les paramètres divers de l'application.
     *
     * @return Response
     */
    public function showAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $subFamilyLog = $etm
            ->getRepository('GlsrGestockBundle:SubFamilyLog')
            ->findAll();

        $zoneStorage = $etm
            ->getRepository('GlsrGestockBundle:ZoneStorage')
            ->findAll();

        $unitStorage = $etm
            ->getRepository('GlsrGestockBundle:UnitStorage')
            ->findAll();

        $tva = $etm->getRepository('GlsrGestockBundle:Tva')->findAll();

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:index.html.twig',
            array(
                'divers' => 1,
                'subfamilylog' => $subFamilyLog,
                'zonestorage' => $zoneStorage,
                'unitstorage' => $unitStorage,
                'tva' => $tva,
            )
        );
    }
}
