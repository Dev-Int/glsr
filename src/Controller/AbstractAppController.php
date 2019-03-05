<?php
/**
 * AbstractController Controller common methods.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see      https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract controller.
 *
 * @category Controller
 */
abstract class AbstractAppController extends AbstractController
{
    /**
     * Lists all items entity.
     *
     * @param string                                    $entityName  Name of Entity
     * @param string                                    $prefixRoute prefix_route
     * @param \Symfony\Component\HttpFoundation\Request $request     Sort request
     *
     * @return array
     */
    public function abstractIndexAction($entityName, $prefixRoute, Request $request = null)
    {
        $etm = $this->getDoctrine()->getManager();
        $paginator = '';
        $entities = $this->getEntity($entityName, $etm);
        $qbd = $etm->createQueryBuilder();
        $qbd->select('count(entity.id)');
        $qbd->from('App:'.$entityName, 'entity');
        $ctEntity = $qbd->getQuery()->getSingleScalarResult();

        if (null !== $request && false === is_array($entities) && null !== $entities) {
            $item = $this->container->getParameter('knp_paginator.page_range');
            $this->addQueryBuilderSort($entities, $prefixRoute);
            $paginator = $this->get('knp_paginator')->paginate($entities, $request->query->get('page', 1), $item);
        }

        return ['entities' => $entities, 'ctEntity' => $ctEntity, 'paginator' => $paginator];
    }

    /**
     * Finds and displays an item entity.
     *
     * @param object $entity      Entity
     * @param string $prefixRoute prefix_route
     *
     * @return array
     */
    public function abstractShowAction($entity, $prefixRoute)
    {
        $deleteForm = $this->createDeleteForm($entity->getId(), $prefixRoute.'_delete');

        return [$prefixRoute => $entity, 'delete_form' => $deleteForm->createView()];
    }

    /**
     * Displays a form to create a new item entity.
     *
     * @param string $entityName  Name of Entity
     * @param string $entityPath  Path of Entity
     * @param string $typePath    Path of FormType
     * @param string $prefixRoute Prefix of Route
     *
     * @return array
     */
    public function abstractNewAction($entityName, $entityPath, $typePath, $prefixRoute)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctEntity = count($etm->getRepository('App:'.$entityName)->findAll());

        // Only ONE record in these entity
        if ('Settings\Company' === $entityName || 'Settings\Settings' === $entityName && $ctEntity >= 1) {
            $return = $this->redirectToRoute('_home');
            $this->addFlash('danger', 'gestock.settings.'.$prefixRoute.'.add2');
        }
        if ('Settings\Company' !== $entityName || 'Settings\Settings' !== $entityName) {
            $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
            $form = $this->createForm($typePath, $entityNew, ['action' => $this->generateUrl($prefixRoute.'_create')]);

            if ('Staff\Group' === $entityName) {
                $this->addRolesAction($form, $entityNew);
            }
            $return = [strtolower($entityName) => $entityNew, 'form' => $form->createView()];
        }

        return $return;
    }

    /**
     * Creates a new item entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Request in progress
     * @param string                                    $entityName  Entity name <i>First letter Upper</i>
     * @param string                                    $entityPath  Path of Entity
     * @param string                                    $typePath    Path of FormType
     * @param string                                    $prefixRoute Prefix of route
     *
     * @return array
     */
    public function abstractCreateAction(Request $request, $entityName, $entityPath, $typePath, $prefixRoute)
    {
        $etm = $this->getDoctrine()->getManager();
        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $form = $this->createForm($typePath, $entityNew, ['action' => $this->generateUrl($prefixRoute.'_create')]);
        if ('Staff\Group' === $entityName) {
            $this->addRolesAction($form, $entityNew);
        }
        $form->handleRequest($request);
        $return = [$entityName => $entityNew, 'form' => $form->createView()];

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            if ('Settings\Article' === $entityName) {
                $entityNew->setQuantity(0.000);
            }
            $etm->persist($entityNew);
            $etm->flush();

            $param = $this->testReturnParam($entityNew, $prefixRoute);
            $route = $form->get('addmore')->isClicked() ? $prefixRoute.'_new' : $prefixRoute.'_show';

            $return = $this->redirectToRoute($route, $param);
        }

        return $return;
    }

    /**
     * Displays a form to edit an existing item entity.
     *
     * @param object $entity      Entity
     * @param string $prefixRoute Prefix of Route
     * @param string $typePath    Path of FormType
     *
     * @return array
     */
    public function abstractEditAction($entity, $prefixRoute, $typePath)
    {
        $param = $this->testReturnParam($entity, $prefixRoute);
        $editForm = $this->createForm(
            $typePath,
            $entity,
            ['action' => $this->generateUrl($prefixRoute.'_update', $param), 'method' => 'PUT']
        );
        if ('group' === $prefixRoute) {
            $this->addRolesAction($editForm, $entity);
        }
        $deleteForm = $this->createDeleteForm($entity->getId(), $prefixRoute.'_delete');

        return [$prefixRoute => $entity, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), ];
    }

    /**
     * Edits an existing item entity.
     *
     * @param object                                    $entity      Entity
     * @param \Symfony\Component\HttpFoundation\Request $request     Request in progress
     * @param string                                    $prefixRoute Prefix of Route
     * @param string                                    $typePath    Path of FormType
     *
     * @return array
     */
    public function abstractUpdateAction($entity, Request $request, $prefixRoute, $typePath)
    {
        $param = $this->testReturnParam($entity, $prefixRoute);
        $editForm = $this->createForm(
            $typePath,
            $entity,
            ['action' => $this->generateUrl($prefixRoute.'_update', $param), 'method' => 'PUT']
        );
        if ('group' === $prefixRoute) {
            $this->addRolesAction($editForm, $entity);
        }
        $editForm->handleRequest($request);
        $deleteForm = $this->createDeleteForm($entity->getId(), $prefixRoute.'_delete');

        $return = [$prefixRoute => $entity, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), ];

        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.edit.ok');

            $return = $this->redirectToRoute($prefixRoute.'_edit', $param);
        }

        return $return;
    }

    /**
     * Deletes an item entity.
     *
     * @param object                                    $entity      Entity
     * @param \Symfony\Component\HttpFoundation\Request $request     Request in progress
     * @param string                                    $prefixRoute Prefix of Route
     *
     * @return array
     */
    public function abstractDeleteAction($entity, Request $request, $prefixRoute)
    {
        $form = $this->createDeleteForm($entity->getId(), $prefixRoute.'_delete');
        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($entity);
            $etm->flush();
        }
    }

    /**
     * Deletes a item entity with Articles.
     *
     * @param object                                    $entity      Entity
     * @param \Symfony\Component\HttpFoundation\Request $request     Request in progress
     * @param string                                    $entityName  Name of Entity
     * @param string                                    $prefixRoute Prefix of Route
     *
     * @return array
     */
    public function abstractDeleteWithArticlesAction($entity, Request $request, $entityName, $prefixRoute)
    {
        $etm = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($entity->getId(), $prefixRoute.'_delete');
        $entityArticles = $etm
            ->getRepository('App:'.$entityName.'Articles')
            ->findBy([$prefixRoute => $entity->getId()]);

        if ($form->handleRequest($request)->isValid()) {
            foreach ($entityArticles as $article) {
                $etm->remove($article);
            }
            $etm->remove($entity);
            $etm->flush();
        }

        return $this->redirect($this->generateUrl($prefixRoute));
    }

    /**
     * AddQueryBuilderSort for the SortAction in views.
     *
     * @param QueryBuilder $qbd  QueryBuilder
     * @param string       $name Order name
     */
    protected function addQueryBuilderSort(QueryBuilder $qbd, $name)
    {
        $alias = '';
        if (is_array($order = $this->get('app.helper.controller')->getOrder($name))) {
            if ($name !== $order['entity']) {
                $rootAlias = current($qbd->getDQLPart('from'))->getAlias();
                $join = current($qbd->getDQLPart('join'));
                foreach ($join as $item) {
                    if ($item->getJoin() === $rootAlias.'.'.$order['entity']) {
                        $alias = $item->getAlias();
                    }
                }
            }
            if ($name === $order['entity']) {
                $alias = current($qbd->getDQLPart('from'))->getAlias();
            }
            $qbd->orderBy($alias.'.'.$order['field'], $order['type']);
        }
    }

    /**
     * Create Delete form.
     *
     * @param int    $id    Id to delete
     * @param string $route Route to redirect
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, ['attr' => ['id' => 'delete']])
            ->setAction($this->generateUrl($route, ['id' => $id]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Test paramters to return.
     *
     * @param object $entity      Entity to return
     * @param string $prefixRoute Entity name to test
     *
     * @return array Parameters to return
     */
    protected function testReturnParam($entity, $prefixRoute)
    {
        $entityArray = ['article', 'supplier', 'familylog', 'zonestorage', 'unit', 'material'];
        if (in_array($prefixRoute, $entityArray, true)) {
            $param = ['slug' => $entity->getSlug()];
        }
        if (!in_array($prefixRoute, $entityArray, true)) {
            $param = ['id' => $entity->getId()];
        }

        return $param;
    }

    /**
     * Get the existing roles.
     *
     * @return array Array of roles
     */
    private function getExistingRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);
        $theRoles = array();

        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }

        return $theRoles;
    }

    /**
     * Add roles to form.
     *
     * @param \Symfony\Component\Form\Form $form  The form in which to insert the roles
     * @param \App\Entity\Staff\Group      $group The entity to deal
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function addRolesAction($form, $group)
    {
        $form->add(
            'roles',
            ChoiceType::class,
            [
                'choices' => $this->getExistingRoles(),
                'choices_as_values' => true,
                'data' => $group->getRoles(),
                'label' => 'Roles',
                'expanded' => true,
                'multiple' => true,
                'mapped' => true,
            ]
        );

        return $form;
    }

    /**
     * Get the entity.
     *
     * @param string                                     $entityName Name of Entity
     * @param \Doctrine\Common\Persistence\ObjectManager $etm        ObjectManager instances
     *
     * @return array|\Doctrine\ORM\QueryBuilder|null Entity elements
     */
    private function getEntity($entityName, ObjectManager $etm)
    {
        $roles = ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];
        switch ($entityName) {
            case 'Settings\Diverse\FamilyLog':
                $entities = $etm->getRepository('App:'.$entityName)->childrenHierarchy();
                break;
            default:
                if (null !== $this->getUser() && in_array($this->getUser()->getRoles()[0], $roles)) {
                    $entities = $etm->getRepository('App:'.$entityName)->getAllItems();
                } else {
                    $entities = $etm->getRepository('App:'.$entityName)->getItems();
                }
        }

        return $entities;
    }
}
