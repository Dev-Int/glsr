<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Settings\Supplier;

/**
 * Description of SupplierController
 *
 * @author dev-int
 */
class SupplierController
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
