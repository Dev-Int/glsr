<?php
namespace AppBundle\Tests\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Form\Type\ArticleType;
use AppBundle\Entity\Article;

/**
 * Description of ArticleTypeTest
 *
 * @author Laurent
 */
class ArticleTypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        // Mock the FormType: entity
        $mockEntityManager = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRegistry = $this->getMockBuilder('\Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRegistry->expects($this->any())->method('getManagerForClass')
            ->will($this->returnValue($mockEntityManager));

        $mockEntityManager ->expects($this->any())->method('getClassMetadata')
            ->withAnyParameters()
            ->will($this->returnValue(new ClassMetadata('entity')));

        $repo = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $mockEntityManager ->expects($this->any())->method('getRepository')
            ->withAnyParameters()
            ->will($this->returnValue($repo));

        $repo->expects($this->any())->method('findAll')
            ->withAnyParameters()
            ->will($this->returnValue(new ArrayCollection()));


        $entityType = new EntityType($mockRegistry);



        return array(new PreloadedExtension(array(
            'entity' => $entityType,
        ), array()));
    }

    public function testSubmitValidData()
    {
        $formData = array(
            'test' => 'test',
            'test2' => 'test2',
        );

        $type = new ArticleType();
        $form = $this->factory->create($type);

        $object = Article::fromArray($formData);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());
        
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    protected function assertQueryBuilderCalled()
    {
        
    }
}
