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
 * @version GIT: <git_id>
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
 * @category Controller
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
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Settings', 'settings', null);
    
        return $return;
    }

    /**
     * Finds and displays a Settings entity.
     *
     * @Route("/{id}/show", name="settings_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Settings $settings Settings item to display
     * @return array
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
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings',
            'AppBundle\Entity\Settings',
            SettingsType::class
        );

        return $return;
    }

    /**
     * Creates a new Settings entity.
     *
     * @Route("/create", name="settings_create")
     * @Method("POST")
     * @Template("AppBundle:Application:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings',
            'AppBundle\Entity\Settings',
            SettingsType::class,
            'settings'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Settings entity.
     *
     * @Route("/{id}/edit", name="settings_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Settings $settings Settings item to edit
     * @return array
     */
    public function editAction(Settings $settings)
    {
        $return = $this->abstractEditAction(
            $settings,
            'settings',
            SettingsType::class
        );

        return $return;
    }

    /**
     * Edits an existing Settings entity.
     *
     * @Route("/{id}/update", name="settings_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Application:edit.html.twig")
     *
     * @param \AppBundle\Entity\Settings                $settings Settings item to update
     * @param \Symfony\Component\HttpFoundation\Request $request  Form request
     * @return array
     */
    public function updateAction(Settings $settings, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $settings,
            $request,
            'settings',
            SettingsType::class
        );

        return $return;
    }

    /**
     * Deletes a Settings entity.
     *
     * @Route("/{id}/delete", name="settings_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\Settings                $settings Settings item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request  Form request
     * @return array
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
