<?php
/**
 * ControllerHelper Helpers de l'application GLSR.
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

use AppBundle\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

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
     * @param array Articles à tester
     * @return boolean
     */
    public function testSupplierHasArticle(array $articles)
    {
        $return = true;

        // This supplier has no articles!
        if (count($articles) < 1) {
            $message = $this->get('translator')->trans('settings.no_articles', array(), 'gs_suppliers');
            $this->addFlash('danger', $message);
            $return = false;
        }

        return $return;
    }

    /**
     * Tests Order in progress for a supplier.
     *
     * @param \AppBundle\Entity\Article $articles Articles to test
     * @param \Doctrine\Common\Persistence\ObjectManager $etm Named object manager
     * @return boolean
     */
    public function testOrderInProgress(Article $articles, ObjectManager $etm)
    {
        $return = false;
        $orders = $etm->getRepository('AppBundle:Orders')->findAll();
        // This provider already has an order in progress!
        foreach ($orders as $order) {
            if ($order->getSupplier() === $articles->getSupplier()) {
                $return = true;
            }
        }
        return $return;
    }
}
