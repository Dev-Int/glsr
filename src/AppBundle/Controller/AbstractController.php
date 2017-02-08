<?php
/**
 * AbstractController controller des méthodes communes.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\QueryBuilder;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Abstract controller.
 *
 * @category Controller
 */
abstract class AbstractController extends Controller
{
    /**
     * Lists all items entity.
     *
     * @param string $entityName Name of Entity
     * @param \Symfony\Component\HttpFoundation\Request $request Sort request
     * @return array
     */
    public function abstractIndexAction($entityName, Request $request = null)
    {
        $etm = $this->getDoctrine()->getManager();
        $paginator = '';
        $entities = $this->getEntity($entityName, $etm);
        
        if ($request !== null) {
            $item = $this->container->getParameter('knp_paginator.page_range');
            $this->addQueryBuilderSort($entities, strtolower($entityName));
            $paginator = $this->get('knp_paginator')->paginate($entities, $request->query->get('page', 1), $item);
        }

        return array('entities'  => $entities, 'ctEntity' => count($entities), 'paginator' => $paginator,);
    }

    /**
     * Get the entity
     *
     * @param string $entityName Name of Entity
     * @param \Doctrine\Common\Persistence\ObjectManager $etm ObjectManager instances
     * @return type
     */
    protected function getEntity($entityName, $etm)
    {
        $roles = ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];
        switch ($entityName) {
            case 'Article':
                if ($this->getUser() !== null && in_array($this->getUser()->getRoles()[0], $roles)) {
                    $entities = $etm->getRepository('AppBundle:'.$entityName)->getAllArticles();
                } else {
                    $entities = $etm->getRepository('AppBundle:'.$entityName)->getArticles();
                }
                break;
            case 'Supplier':
                if ($this->getUser() !== null && in_array($this->getUser()->getRoles()[0], $roles)) {
                    $entities = $etm->getRepository('AppBundle:'.$entityName)->getAllSuppliers();
                } else {
                    $entities = $etm->getRepository('AppBundle:'.$entityName)->getSuppliers();
                }
                break;
            case 'User':
                $entities = $etm->getRepository('AppBundle:'.$entityName)->getUsers();
                break;
            case 'FamilyLog':
                $entities = $etm->getRepository('AppBundle:'.$entityName)->childrenHierarchy();
                break;
            case 'UnitStorage':
                $entities = $etm->getRepository('AppBundle:'.$entityName)->createQueryBuilder('u');
                break;
            default:
                $entities = $etm->getRepository('AppBundle:'.$entityName)->findAll();
        }
        return $entities;
    }

    /**
     * Finds and displays an item entity.
     *
     * @param Object $entity     Entity
     * @param string $entityName Name of Entity
     * @return array
     */
    public function abstractShowAction($entity, $entityName)
    {
        $deleteForm = $this->createDeleteForm($entity->getId(), $entityName.'_delete');

        return array(
            $entityName => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new item entity.
     *
     * @param string      $entity     Entity
     * @param string      $entityPath Path of Entity
     * @param string      $typePath   Path of FormType
     * @return array
     */
    public function abstractNewAction($entity, $entityPath, $typePath)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctEntity = count($etm->getRepository('AppBundle:'.$entity)->findAll());
        
        if ($entity === 'Company' || $entity === 'Settings' && $ctEntity >= 1) {
            $return = $this->redirectToRoute('_home');
            $this->addFlash('danger', 'gestock.settings.'.strtolower($entity).'.add2');
        }

        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $form = $this->createForm($typePath, $entityNew, array(
            'action' => $this->generateUrl(strtolower($entity).'_create'),
        ));

        if ($entity === 'Group') {
            $this->addRolesAction($form, $entityNew);
        }
        $return = array(strtolower($entity) => $entityNew, 'form'   => $form->createView(),);

        return $return;
    }

    /**
     * Creates a new item entity.
     *
     * @param Request $request   Request in progress
     * @param string $entity     Entity <i>First letter Upper</i>
     * @param string $entityPath Path of Entity
     * @param string $typePath   Path of FormType
     * @return array
     */
    public function abstractCreateAction(Request $request, $entity, $entityPath, $typePath)
    {
        $param = array();
        $etm = $this->getDoctrine()->getManager();
        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $form = $this->createForm($typePath, $entityNew, array(
            'action' => $this->generateUrl(strtolower($entity).'_create'),
        ));
        if ($entity === 'Group') {
            $this->addRolesAction($form, $entityNew);
        }
        $form->handleRequest($request);
        $return = [$entity => $entityNew, 'form' => $form->createView(),];

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($entityNew);
            $etm->flush();

            $param = $this->testReturnParam($entityNew, strtolower($entity));
            $route = $form->get('addmore')->isClicked() ? strtolower($entity).'_new' : strtolower($entity).'_show';

            $return = $this->redirectToRoute($route, $param);
        }

        return $return;
    }

    /**
     * Displays a form to edit an existing item entity.
     *
     * @param Object $entity     Entity
     * @param string $entityName Name of Entity
     * @param string $typePath   Path of FormType
     * @return array
     */
    public function abstractEditAction($entity, $entityName, $typePath)
    {
        $param = $this->testReturnParam($entity, $entityName);
        $editForm = $this->createForm($typePath, $entity, array(
            'action' => $this->generateUrl($entityName.'_update', $param),
            'method' => 'PUT',
        ));
        if ($entityName === 'group') {
            $this->addRolesAction($editForm, $entity);
        }
        $deleteForm = $this->createDeleteForm($entity->getId(), $entityName.'_delete');

        return array(
            $entityName => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing item entity.
     *
     * @param Object $entity     Entity
     * @param Request $request   Request in progress
     * @param string $entityName Name of Entity
     * @param string $typePath   Path of FormType
     * @return array
     */
    public function abstractUpdateAction($entity, Request $request, $entityName, $typePath)
    {
        $param = $this->testReturnParam($entity, $entityName);
        $editForm = $this->createForm($typePath, $entity, array(
            'action' => $this->generateUrl($entityName.'_update', $param),
            'method' => 'PUT',
        ));
        if ($entityName === 'group') {
            $this->addRolesAction($editForm, $entity);
        }
        $editForm->handleRequest($request);
        $deleteForm = $this->createDeleteForm($entity->getId(), $entityName.'_delete');

        $return = array(
            $entityName => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),);

        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.edit.ok');

            $return = $this->redirectToRoute($entityName.'_edit', $param);
        }

        return $return;
    }

    /**
     * Deletes an item entity.
     *
     * @param Object $entity     Entity
     * @param Request $request   Request in progress
     * @param string $entityName Name of Entity
     * @return array
     */
    public function abstractDeleteAction($entity, Request $request, $entityName)
    {
        $form = $this->createDeleteForm($entity->getId(), $entityName.'_delete');
        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($entity);
            $etm->flush();
        }
    }

    /**
     * Deletes a item entity with Articles.
     *
     * @param Object $entity     Entity
     * @param Request $request   Request in progress
     * @param string $entityName Name of Entity
     * @return array
     */
    public function abstractDeleteWithArticlesAction($entity, Request $request, $entityName)
    {
        $etm = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($entity->getId(), $entityName . '_delete');
        $entityArticles = $etm
            ->getRepository('AppBundle:' .  ucfirst($entityName) . 'Articles')
            ->findBy([$entityName => $entity->getId()]);

        if ($form->handleRequest($request)->isValid()) {
            foreach ($entityArticles as $article) {
                $etm->remove($article);
            }
            $etm->remove($entity);
            $etm->flush();
        }

        return $this->redirect($this->generateUrl($entityName));
    }

    private function testReturnParam($entity, $entityName)
    {
        $entityArray = ['company', 'settings', 'group', 'tva'];
        if (in_array($entityName, $entityArray, true)) {
            $param = array('id' => $entity->getId());
        } else {
            $param = array('slug' => $entity->getSlug());
        }

        return $param;
    }

    /**
     * SetOrder for the SortAction in views.
     *
     * @param string $name   session name
     * @param string $entity entity name
     * @param string $field  field name
     * @param string $type   sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $entity, $field, $type = 'ASC')
    {
        $session = new Session();

        $session->set('sort.'.$name, array('entity' => $entity, 'field' => $field, 'type' => $type));
    }

    /**
     * GetOrder for the SortAction in views.
     *
     * @param string $name session name
     *
     * @return array
     */
    protected function getOrder($name)
    {
        $session = new Session();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * AddQueryBuilderSort for the SortAction in views.
     *
     * @param QueryBuilder $qbd
     * @param string       $name
     */
    protected function addQueryBuilderSort(QueryBuilder $qbd, $name)
    {
        $alias = '';
        if (is_array($order = $this->getOrder($name))) {
            if ($name !== $order['entity']) {
                $rootAlias = current($qbd->getDQLPart('from'))->getAlias();
                $join = current($qbd->getDQLPart('join'));
                foreach ($join as $item) {
                    if ($item->getJoin() === $rootAlias.'.'.$order['entity']) {
                        $alias = $item->getAlias();
                    }
                }
            } else {
                $alias = current($qbd->getDQLPart('from'))->getAlias();
            }
            $qbd->orderBy($alias . '.' . $order['field'], $order['type']);
        }
    }

    /**
     * Create Delete form.
     *
     * @param int    $id
     * @param string $route
     *
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

    /**
     * Array of file (`pdf`) layout.
     *
     * @param string $date File date
     * @param string $title File title
     * @return array<string,integer|string|boolean>
     */
    protected function getArray($date, $title)
    {
        $array = array(
            'margin-top' => 15,
            'header-spacing' => 5,
            'header-font-size' => 8,
            'header-left' => 'G.L.S.R.',
            'header-center' => $title,
            'header-right' => $date,
            'header-line' => true,
            'margin-bottom' => 15,
            'footer-spacing' => 5,
            'footer-font-size' => 8,
            'footer-left' => 'GLSR &copy 2014 and beyond.',
            'footer-right' => 'Page [page]/[toPage]',
            'footer-line' => true,
        );
        return $array;
    }

    /**
     * Get the existing roles
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
     * Add roles to form
     *
     * @param \Symfony\Component\Form\Form  $form  The form in which to insert the roles
     * @param \AppBundle\Entity\Group       $group The entity to deal
     * @return \Symfony\Component\Form\Form The form
     */
    public function addRolesAction($form, $group)
    {
        $form->add('roles', ChoiceType::class, array(
            'choices' => $this->getExistingRoles(),
            'choices_as_values' => true,
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));

        return $form;
    }
}
