<?php

namespace Glsr\GestockBundle\Tests\Supplier;

use Glsr\GestockBundle\Controller\SupplierController;
use Glsr\GestockBundle\Entity\Supplier;

/**
 * Description of SupplierTest
 *
 * @author Laurent
 */
class SupplierControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testAddAction()
    {
        $supplier = new Supplier();
    }
}
