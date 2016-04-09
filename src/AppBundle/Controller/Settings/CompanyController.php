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
     * @Route("/", name="admin_company")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Company')->findAll();
        
        return array(
            'entities'  => $entities,
            'ctEntity' => count($entities),
        );
    }

    /**
     * Finds and displays a Company entity.
     *
     * @Route("/{id}/show", name="admin_company_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Company $company)
    {
        $deleteForm = $this->createDeleteForm($company->getId(), 'admin_company_delete');

        return array(
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Company entity.
     *
     * @Route("/new", name="admin_company_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $company = new Company();
        $form = $this->createForm(new CompanyType(), $company);

        return array(
            'company' => $company,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Company entity.
     *
     * @Route("/create", name="admin_company_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Company:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(new CompanyType(), $company);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('admin_company_show', array('id' =>$company->getId()));
        }

        return array(
            'company' => $company,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     * @Route("/{id}/edit", name="admin_company_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Company $company = null)
    {
        $editForm = $this->createForm(new CompanyType(), $company, array(
            'action' => $this->generateUrl('admin_company_update', array('id' => $company->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($company->getId(), 'admin_company_delete');

        return array(
            'company' => $company,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Company entity.
     *
     * @Route("/{id}/update", name="admin_company_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Company:edit.html.twig")
     */
    public function updateAction(Request $request, Company $company = null)
    {
        $editForm = $this->createForm(new CompanyType(), $company, array(
            'action' => $this->generateUrl('admin_company_update', array('id' => $company->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.settings.edit_ok');

            return $this->redirectToRoute('admin_company_show', array('id' => $company->getId()));
        }
        $deleteForm = $this->createDeleteForm($company->getId(), 'admin_company_delete');

        return array(
            'company' => $company,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/{id}/delete", name="admin_company_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Company $company = null)
    {
        $form = $this->createDeleteForm($company->getId(), 'admin_company_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('admin_company');
    }
}
