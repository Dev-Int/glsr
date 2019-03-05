<?php
/**
 * CompanyController Configuration controller of the establishment.
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
namespace App\Controller\Settings;

use App\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Settings\Company;
use App\Form\Type\Settings\CompanyType;

/**
 * Company controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/company")
 */
class CompanyController extends AbstractAppController
{
    /**
     * Lists all Company entities.
     *
     * @Route("/", name="company")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Settings\Company', 'company', null);
    
        return $return;
    }

    /**
     * Finds and displays a Company entity.
     *
     * @Route("/{id}/show", name="company_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Company $company Company item to display
     * @return array
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
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings\Company',
            'App\Entity\Settings\Company',
            CompanyType::class,
            'company'
        );

        return $return;
    }

    /**
     * Creates a new Company entity.
     *
     * @Route("/create", name="company_create")
     * @Method("POST")
     * @Template("settings/company/new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Company',
            'App\Entity\Settings\Company',
            CompanyType::class,
            'company'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     * @Route("/{id}/edit", name="company_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Company $company Company item to edit
     * @return array
     */
    public function editAction(Company $company)
    {
        $return = $this->abstractEditAction(
            $company,
            'company',
            CompanyType::class
        );

        return $return;
    }

    /**
     * Edits an existing Company entity.
     *
     * @Route("/{id}/update", name="company_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("settings/company/edit.html.twig")
     *
     * @param \App\Entity\Settings\Company              $company Company item to update
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function updateAction(Company $company, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $company,
            $request,
            'company',
            CompanyType::class
        );

        return $return;
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/{id}/delete", name="company_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \App\Entity\Settings\Company              $company Company item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
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
