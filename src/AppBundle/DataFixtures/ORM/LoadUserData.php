<?php
/**
 * LoadUserData Données User de l'application GLSR.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Staff\User;
use AppBundle\Entity\Staff\Group;

/**
 * LoadUser Data.
 *
 * @category DataFixtures
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('Admin');
        $userAdmin->setEmail('admin@localhost');
        $userAdmin->setEnabled(true);
        $userAdmin->setSalt(md5(uniqid()));
        
        // the 'security.password_encoder' service requires Symfony 2.6 or higher
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($password);

        $group = new Group('admin', 'ROLE_SUPER_ADMIN');
        var_dump($group);
        $userAdmin->setGroups($group->getId(1));

        $manager->persist($userAdmin);
        $manager->flush();

        $this->addReference('admin-user', $userAdmin);
    }

    public function getOrder()
    {
        return 2;
    }
}
