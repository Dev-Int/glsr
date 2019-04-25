<?php

/**
 * SupplierController Controller of Supplier entity.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use App\Entity\Settings\Supplier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;

/**
 * Description of SupplierController.
 *
 * @category Controller
 */
class SupplierController extends BaseAdminController
{
    /**
     * Allows applications to modify the entity associated with the item being
     * deleted before removing it.
     *
     * @param \App\Entity\Settings\Supplier $supplier
     */
    protected function removeSupplierEntity(Supplier $supplier)
    {
        $supplier->setActive(false);
        $this->em->/** @scrutinizer ignore-call */
            persist($supplier);
        $this->em->/** @scrutinizer ignore-call */
            flush();
    }
}
