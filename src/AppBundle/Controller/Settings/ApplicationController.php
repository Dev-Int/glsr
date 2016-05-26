<?php
/**
 * ApplicationController controller de configuration de l'application.
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
namespace AppBundle\Controller\Settings;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Settings;
use AppBundle\Form\Type\SettingsType;

/**
 * Application controller.
 *
 * @category   Controller
 *
 * @Route("/admin/settings/application")
 */
class ApplicationController extends AbstractController
{
    /**
     * Lists all Settings entities.
     *
     * @Route("/", name="application")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Settings');
    
        return $return;
    }

    /**
     * Finds and displays a Settings entity.
     *
     * @Route("/{id}/show", name="settings_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Settings $settings)
    {
        $return = $this->abstractShowAction($settings, 'settings');

        return $return;
    }

    /**
     * Displays a form to create a new Settings entity.
     *
     * @Route("/new", name="settings_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings',
            'AppBundle\Entity\Settings',
            'AppBundle\Form\Type\SettingsType'
        );

        return $return;
    }

    /**
     * Creates a new Settings entity.
     *
     * @Route("/create", name="settings_create")
     * @Method("POST")
     * @Template("AppBundle:Application:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'settings',
            'AppBundle\Entity\Settings',
            'AppBundle\Form\Type\SettingsType'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Settings entity.
     *
     * @Route("/{id}/edit", name="settings_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Settings $settings)
    {
        $return = $this->abstractEditAction(
            $settings,
            'settings',
            'AppBundle\Form\Type\SettingsType'
        );

        return $return;
    }

    /**
     * Edits an existing Settings entity.
     *
     * @Route("/{id}/update", name="settings_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Application:edit.html.twig")
     */
    public function updateAction(Settings $settings, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $settings,
            $request,
            'settings',
            'AppBundle\Form\Type\SettingsType'
        );

        return $return;
    }

    /**
     * Deletes a Settings entity.
     *
     * @Route("/{id}/delete", name="settings_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Settings $settings, Request $request)
    {
        $this->abstractDeleteAction(
            $settings,
            $request,
            'settings'
        );

        return $this->redirectToRoute('application');
    }
}
