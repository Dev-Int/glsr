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
use AppBundle\Entity\Company;
use AppBundle\Form\Type\CompanyType;

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
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Company', 'company', null);
    
        return $return;
    }

    /**
     * Finds and displays a Company entity.
     *
     * @Route("/{id}/show", name="company_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Company $company Company item to display
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
            'Company',
            'AppBundle\Entity\Company',
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
     * @Template("AppBundle:Settings/Company:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Company',
            'AppBundle\Entity\Company',
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
     * @param \AppBundle\Entity\Company $company Company item to edit
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
     * @Template("AppBundle:Company:edit.html.twig")
     *
     * @param \AppBundle\Entity\Company                 $company Company item to update
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
     * @param \AppBundle\Entity\Company                 $company Company item to delete
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
