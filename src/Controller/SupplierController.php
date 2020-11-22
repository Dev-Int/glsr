<?php

namespace App\Controller;

use Doctrine\ORM\ORMException;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\Entity\Settings\Supplier;

class SupplierController extends BaseAdminController
{
    /**
     * Allows applications to modify the entity associated with the item being
     * deleted before removing it.
     *
     * @throws ORMException
     */
    protected function removeSupplierEntity(Supplier $supplier): void
    {
        $supplier->setActive(false);
        $this->em->persist($supplier);
        $this->em->flush();
    }
}
