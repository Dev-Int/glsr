<?php
/**
 * ControllerHelper controller de l'application GLSR.
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
namespace AppBundle\Helper;

/**
 * Controller helper.
 *
 * @category Helper
 */
class ControllerHelper
{
    /**
     * Tests of creation conditions.
     *
     * @param array $article Articles à tester
     * @return boolean
     */
    public function testCreate($article, $etm)
    {
        $return = false;
        $orders = $etm->getRepository('AppBundle:Orders')->findAll();
        // This provider already has an order in progress!
        foreach ($orders as $order) {
            if ($order->getSupplier() === $article->getSupplier()) {
                $return = true;
            }
        }
        return $return;
    }
}
