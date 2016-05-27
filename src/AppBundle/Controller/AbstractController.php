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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\QueryBuilder;

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
     * @return array
     */
    public function abstractIndexAction($entityName)
    {
        $etm = $this->getDoctrine()->getManager();
        $entities = $etm->getRepository('AppBundle:'.$entityName)->findAll();

        return array(
            'entities'  => $entities,
            'ctEntity' => count($entities),
        );
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
     * @param string $entity     Entity
     * @param string $entityPath Path of Entity
     * @param string $typePath   Path of FormType
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
        $form = $this->createForm(new $typePath(), $entityNew);

        $return = array(strtolower($entity) => $entityNew, 'form'   => $form->createView(),);

        return $return;
    }

    /**
     * Creates a new item entity.
     *
     * @param Request $request   Request in progress
     * @param string $entity     Entity
     * @param string $entityPath Path of Entity
     * @param string $typePath   Path of FormType
     * @return array
     */
    public function abstractCreateAction(Request $request, $entity, $entityPath, $typePath)
    {
        $etm = $this->getDoctrine()->getManager();
        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $form = $this->createForm(new $typePath(), $entityNew);

        $return = array($entity => $entityNew, 'form'   => $form->createView(),);
        
        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($entityNew);
            $etm->flush();

            if ($form->get('save')->isSubmitted()) {
                if ($entity === 'tva') {
                    $param = array('id' => $entityNew->getId());
                } else {
                    $param = array('slug' => $entityNew->getSlug());
                }
                $return = $this->redirect($this->generateUrl(
                    $entity.'_show', $param
                ));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $return = $this->redirect($this->generateUrl($entity.'_new'));
            } else {
                $return = $this->redirect($this->generateUrl(
                    $entity.'_show', array('id' => $entityNew->getId())
                ));
            }
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
        if ($entityName === 'company' || $entityName === 'settings' || $entityName === 'tva') {
            $param = array('id' => $entity->getId());
        } else {
            $param = array('slug' => $entity->getSlug());
        }
        $editForm = $this->createForm(new $typePath(), $entity, array(
            'action' => $this->generateUrl($entityName.'_update', $param),
            'method' => 'PUT',
        ));
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
        if ($entityName === 'company' || $entityName === 'settings' || $entityName === 'tva') {
            $param = array('id' => $entity->getId());
            if ($entityName !== 'tva') {
                $transName = $entityName;
            } else {
                $transName = 'diverse';
            }
        } else {
            $param = array('slug' => $entity->getSlug());
            $transName = 'diverse';
        }
        $editForm = $this->createForm(new $typePath(), $entity, array(
            'action' => $this->generateUrl($entityName.'_update', $param),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.settings.'.$transName.'.edit_ok');

            return $this->redirectToRoute($entityName.'_edit', $param);
        }
        $deleteForm = $this->createDeleteForm($entity->getId(), $entityName.'_delete');

        return array(
            $entityName => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
     * SetOrder for the SortAction in views.
     *
     * @param string $name  session name
     * @param string $field field name
     * @param string $type  sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $field, $type = 'ASC')
    {
        $this->getRequest()->getSession()->set('sort.'.$name, array('field' => $field, 'type' => $type));
    }

    /**
     * GetOrder for the SortAction in views.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getOrder($name)
    {
        $session = $this->getRequest()->getSession();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * AddQueryBuilderSort for the SortAction in views.
     *
     * @param QueryBuilder $qb
     * @param string       $name
     */
    protected function addQueryBuilderSort(QueryBuilder $qb, $name)
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();
        if (is_array($order = $this->getOrder($name))) {
            $qb->orderBy($alias . '.' . $order['field'], $order['type']);
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
     * Test Inventory.
     *
     * @return string|null
     */
    protected function testInventory()
    {
        $url = null;
        $etm = $this->getDoctrine()->getManager();
        $inventories = $etm->getRepository('AppBundle:Inventory')->getInventory();

        if (empty($inventories)) {
            $url = 'gs_install_st7';
        } else {
            foreach ($inventories as $inventory) {
                if ($inventory->getstatus() === 1 || $inventory->getStatus() === 2) {
                    $message = $this->get('translator')
                        ->trans('yet', array(), 'gs_inventories');
                    $this->addFlash('danger', $message);
                    $url = 'inventory';
                    break;
                }
            }
        }

        return $url;
    }
}
