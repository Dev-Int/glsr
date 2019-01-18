<?php

/**
 * SupplierController Controller of Supplier entity.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\Entity\Settings\Supplier;

/**
 * Description of SupplierController
 *
 * @category Controller
 */
class SupplierController extends BaseAdminController
{
    /**
     * Allows applications to modify the entity associated with the item being
     * deleted before removing it.
     *
     * @param Article $supplier
     */
    protected function removeSupplierEntity(Supplier $supplier)
    {
        $supplier->setActive(false);
        $this->em->persist($supplier);
        $this->em->flush();
    }
}
