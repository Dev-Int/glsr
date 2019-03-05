<?php
/**
 * ControllerHelper Helpers des Controller de l'application GLSR.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace App\Helper;

use App\Entity\Settings\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Controller helper.
 *
 * @category Helper
 */
class ControllerHelper
{
    protected $translator;
    protected $session;

    public function __construct($translator, $session)
    {
        $this->translator = $translator;
        $this->session = $session;
    }

    /**
     * Tests of creation conditions.
     *
     * @param array $articles Articles to test
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
     * @param \App\Entity\Settings\Article               $articles Articles to test
     * @param \Doctrine\Common\Persistence\ObjectManager $etm      Named object manager
     * @return boolean
     */
    public function isOrderInProgress(Article $articles, ObjectManager $etm)
    {
        $return = false;
        $orders = $etm->getRepository('App:Orders\Orders')->findAll();
        // This supplier already has an order in progress!
        foreach ($orders as $order) {
            if ($order->getSupplier() === $articles->getSupplier()) {
                $return = true;
            }
        }
        return $return;
    }

    /**
     * Array of file (`pdf`) layout.
     *
     * @param string $date  File date
     * @param string $title File title
     * @return array
     */
    public function getArray($date, $title)
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
     * SetOrder for the SortAction in views.
     *
     * @param string $name   session name
     * @param string $entity entity name
     * @param string $field  field name
     * @param string $type   sort type ("ASC"/"DESC")
     */
    public function setOrder($name, $entity, $field, $type = 'ASC')
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
    public function getOrder($name)
    {
        $session = new Session();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }
}