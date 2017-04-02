<?php
/**
 * AbstractEntity Méthodes abstraites des Entity.
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
 * Abstract Entity.
 *
 * @category Helper
 */
abstract class AbstractEntity
{
    abstract protected function testReturnParam(AbstractEntity $entity, $entityName);
    abstract public function getId();
    abstract public function getSlug();
}
