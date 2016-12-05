<?php
/**
 * AbstractOrdersController Méthodes communes InventoryController.
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

use AppBundle\Controller\AbstractController;
use AppBundle\Entity\Orders;
use AppBundle\Form\Type\OrdersType;

/**
 * Abstract controller.
 *
 * @category Controller
 */
class AbstractOrdersController extends AbstractController
{
    /**
     * Create CreateForm.
     *
     * @param string $route Route of action form
     * @return \Symfony\Component\Form\Form
     */
    protected function createCreateForm($route)
    {
        $orders = new Orders();
        return $this->createForm(
            OrdersType::class,
            $orders,
            ['attr' => ['id' => 'create'], 'action' => $this->generateUrl($route), 'method' => 'POST',]
        );
    }
}
