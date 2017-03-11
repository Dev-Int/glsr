<?php
/**
 * ControllerHelper Helpers des Controller de l'application GLSR.
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
    public function __construct($translator, $session)
    {
        $this->translator = $translator;
        $this->session = $session;
    }
    /**
     * Tests of creation conditions.
     *
     * @param array Articles à tester
     * @return boolean
     */
    public function hasSupplierArticles(array $articles)
    {
        $return = true;

        // This supplier has no articles!
        if (count($articles) < 1) {
            $message = $this->translator->trans('settings.no_articles', array(), 'gs_suppliers');
            $this->session->getFlashBag()->add('danger', $message);
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
    public function isOrderInProgress(Article $articles, ObjectManager $etm)
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

    /**
     * test paramters to return
     *
     * @param object $entity     Entity to return
     * @param string $entityName Entity name to test
     * @return array             Parameters to return
     */
    protected function testReturnParam($entity, $entityName)
    {
        $entityArray = ['company', 'settings', 'group', 'tva'];
        if (in_array($entityName, $entityArray, true)) {
            $param = ['id' => $entity->getId()];
        } else {
            $param = ['slug' => $entity->getSlug()];
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
}
