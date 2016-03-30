<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** * @var ContainerInterface */
    private $container;

    /** * {@inheritDoc} */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder() {
        return 0;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();

        $user
            ->setUsername('someguy')
            ->setEmail('john.doe@example.com')
            ->setFirstLogin(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'))
            ->setEnabled(true);
        
        $user->setPlainPassword('somepass');

        $userManager->updateUser($user);
    }     
}
