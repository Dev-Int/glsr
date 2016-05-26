<?php
/**
 * CompanyController controller de configuration de l'établissement.
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
use AppBundle\Entity\Company;

/**
 * Company controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/company")
 */
class CompanyController extends AbstractController
{
    /**
     * Lists all Company entities.
     *
     * @Route("/", name="company")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Company');
    
        return $return;
    }

    /**
     * Finds and displays a Company entity.
     *
     * @Route("/{id}/show", name="company_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Company $company)
    {
        $return = $this->abstractShowAction($company, 'company');

        return $return;
    }

    /**
     * Displays a form to create a new Company entity.
     *
     * @Route("/new", name="company_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Company',
            'AppBundle\Entity\Company',
            'AppBundle\Form\Type\CompanyType'
        );

        return $return;
    }

    /**
     * Creates a new Company entity.
     *
     * @Route("/create", name="company_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Company:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'company',
            'AppBundle\Entity\Company',
            'AppBundle\Form\Type\CompanyType'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     * @Route("/{id}/edit", name="company_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Company $company)
    {
        $return = $this->abstractEditAction(
            $company,
            'company',
            'AppBundle\Form\Type\CompanyType'
        );

        return $return;
    }

    /**
     * Edits an existing Company entity.
     *
     * @Route("/{id}/update", name="company_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Company:edit.html.twig")
     */
    public function updateAction(Company $company, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $company,
            $request,
            'company',
            'AppBundle\Form\Type\CompanyType'
        );

        return $return;
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/{id}/delete", name="company_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Company $company, Request $request)
    {
        $this->abstractDeleteAction(
            $company,
            $request,
            'company'
        );

        return $this->redirectToRoute('company');
    }
}
