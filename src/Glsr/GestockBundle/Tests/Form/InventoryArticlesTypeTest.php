<?php
namespace Glsr\GestockBundle\Tests\Form;

use Glsr\GestockBundle\Form\InventoryArticlesType;
use Symfony\Component\Form\Test\TypeTestCase;

class InventoryArticlesTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'inventory' => 1,
            'articles' => 2,
            'realstock' => 0.500,
            'total' => 2.250
        );

        $type = new InventoryArticlesType();
        $form = $this->factory->create($type);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
//        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}