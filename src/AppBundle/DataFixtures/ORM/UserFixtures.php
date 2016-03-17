<?php 
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
//use AppBundle\Entity\User;
//use AppBundle\Entity\Group;

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
 
    public function load(ObjectManager $manager) {
 
        $userManager = $this->container->get('fos_user.user_manager');
         
        $user = $userManager->createUser();
         
        $user
            ->setUsername('someguy')
            ->setEmail('john.doe@example.com')
            ->setFirstLogin(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'))
            ->setEnabled(true);
         
        $user->setPlainPassword('somepass');
 
        // Equivalent à :
         
//        $encoder = $this->container
//                ->get('security.encoder_factory')
//                ->getEncoder($user)
//            ;
//        $user->setPassword($encoder->encodePassword('somepass', $user->getSalt()));
 
         
        $userManager->updateUser($user);
    }     
}