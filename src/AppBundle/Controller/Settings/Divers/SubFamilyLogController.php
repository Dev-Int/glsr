<?php

namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\SubFamilyLog;
use AppBundle\Form\Type\SubFamilyLogType;

/**
 * SubFamilyLog controller.
 *
 * @Route("/admin/settings/divers/subfamilylog")
 */
class SubFamilyLogController extends Controller
{
    /**
     * Lists all SubFamilyLog entities.
     *
     * @Route("/", name="admin_subfamilylog")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:SubFamilyLog')->createQueryBuilder('s');
        $this->addQueryBuilderSort($qb, 'subfamilylog');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 20);
        
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a SubFamilyLog entity.
     *
     * @Route("/{slug}/show", name="admin_subfamilylog_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(SubFamilyLog $subfamilylog)
    {
        $deleteForm = $this->createDeleteForm($subfamilylog->getId(), 'admin_subfamilylog_delete');

        return array(
            'subfamilylog' => $subfamilylog,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new SubFamilyLog entity.
     *
     * @Route("/new", name="admin_subfamilylog_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $subfamilylog = new SubFamilyLog();
        $form = $this->createForm(new SubFamilyLogType(), $subfamilylog);

        return array(
            'subfamilylog' => $subfamilylog,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SubFamilyLog entity.
     *
     * @Route("/create", name="admin_subfamilylog_create")
     * @Method("POST")
     * @Template("AppBundle:SubFamilyLog:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $subfamilylog = new SubFamilyLog();
        $form = $this->createForm(new SubFamilyLogType(), $subfamilylog);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subfamilylog);
            $em->flush();

            if ($form->get('save')->isClicked()) {
                $url = $this->redirect(
                    $this->generateUrl(
                        'admin_subfamilylog_show',
                        array('slug' => $subfamilylog->getSlug())
                    )
                );
            } elseif ($form->get('addmore')->isClicked()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $url = $this->redirect($this->generateUrl('admin_subfamilylog_new'));
            }
            return $url;
        }

        return array(
            'subfamilylog' => $subfamilylog,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SubFamilyLog entity.
     *
     * @Route("/{slug}/edit", name="admin_subfamilylog_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(SubFamilyLog $subfamilylog)
    {
        $editForm = $this->createForm(new SubFamilyLogType(), $subfamilylog, array(
            'action' => $this->generateUrl(
                'admin_subfamilylog_update',
                array('slug' => $subfamilylog->getSlug())
            ),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($subfamilylog->getId(), 'admin_subfamilylog_delete');

        return array(
            'subfamilylog' => $subfamilylog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SubFamilyLog entity.
     *
     * @Route("/{slug}/update", name="admin_subfamilylog_update")
     * @Method("PUT")
     * @Template("AppBundle:SubFamilyLog:edit.html.twig")
     */
    public function updateAction(SubFamilyLog $subfamilylog, Request $request)
    {
        $editForm = $this->createForm(new SubFamilyLogType(), $subfamilylog, array(
            'action' => $this->generateUrl(
                'admin_subfamilylog_update',
                array('slug' => $subfamilylog->getSlug())
            ),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl(
                'admin_subfamilylog_edit',
                array('slug' => $subfamilylog->getSlug())
            ));
        }
        $deleteForm = $this->createDeleteForm($subfamilylog->getId(), 'admin_subfamilylog_delete');

        return array(
            'subfamilylog' => $subfamilylog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="admin_subfamilylog_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('subfamilylog', $field, $type);

        return $this->redirect($this->generateUrl('admin_subfamilylog'));
    }

    /**
     * @param string $name  session name
     * @param string $field field name
     * @param string $type  sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $field, $type = 'ASC')
    {
        $this->getRequest()->getSession()->set(
            'sort.' . $name,
            array('field' => $field, 'type' => $type)
        );
    }

    /**
     * @param  string $name
     * @return array
     */
    protected function getOrder($name)
    {
        $session = $this->getRequest()->getSession();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $name
     */
    protected function addQueryBuilderSort(\Doctrine\ORM\QueryBuilder $qb, $name)
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();
        if (is_array($order = $this->getOrder($name))) {
            $qb->orderBy($alias . '.' . $order['field'], $order['type']);
        }
    }

    /**
     * Deletes a SubFamilyLog entity.
     *
     * @Route("/{id}/delete", name="admin_subfamilylog_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(SubFamilyLog $subfamilylog, Request $request)
    {
        $form = $this->createDeleteForm($subfamilylog->getId(), 'admin_subfamilylog_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subfamilylog);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_subfamilylog'));
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
