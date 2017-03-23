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

use AppBundle\Helper\AbstractEntity;
use AppBundle\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Controller helper.
 *
 * @category Helper
 */
class ControllerHelper extends AbstractEntity
{
    private $translator;
    private $session;
    private $security;

    public function __construct($translator, $session, $security)
    {
        $this->translator = $translator;
        $this->session = $session;
        $this->security = $security;
    }

    /**
     * Get the entity
     *
     * @param string $entityName Name of Entity
     * @param \Doctrine\Common\Persistence\ObjectManager $etm ObjectManager instances
     * @return array|\Doctrine\ORM\QueryBuilder|null Entity elements
     */
    public function getEntity($entityName, ObjectManager $etm)
    {
        $roles = ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];
        switch ($entityName) {
            case 'Article':
            case 'Supplier':
                if ($this->security->getToken()->getUser() !== null &&
                    in_array($this->security->getToken()->getUser()->getRoles()[0], $roles)) {
                    $entities = $etm->getRepository('AppBundle:'.$entityName)->getAllItems();
                } else {
                    $entities = $etm->getRepository('AppBundle:'.$entityName)->getItems();
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
     * Array of file (`pdf`) layout.
     *
     * @param string $date  File date
     * @param string $title File title
     * @return array
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
     * Test paramters to return.
     *
     * @param \AppBundle\Helper\AbstractEntity $entity     Entity to return
     * @param string                           $entityName Entity name to test
     * @return array Parameters to return
     */
    protected function testReturnParam(AbstractEntity $entity, $entityName)
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
    public function getOrder($name)
    {
        $session = new Session();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }
}
