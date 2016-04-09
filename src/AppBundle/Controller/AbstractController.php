<?php
/**
 * UserController controller des utilisateurs.
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
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract controller.
 *
 * @category Controller
 */
abstract class AbstractController extends Controller
{
    abstract protected function newAction();
    
    abstract protected function createAction(Request $request);
    
    abstract protected function editAction();
    
    abstract protected function updateAction(Request $request);
    
    abstract protected function deleteAction(Request $request);
    
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
