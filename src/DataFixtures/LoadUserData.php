<?php
/**
 * LoadUserData User data from the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see      https://github.com/Dev-Int/glsr
 */

namespace App\DataFixtures;

use App\Entity\Staff\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * LoadUser Data.
 *
 * @category DataFixtures
 */
class LoadUserData extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    /**
     * Encoder.
     *
     * @var UserPasswordEncoderInterface
     */
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('Admin');
        $userAdmin->setEmail('admin@localhost');
        $userAdmin->setEnabled(true);
        $userAdmin->setSalt(md5(uniqid()));

        $password = $this->encoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($password);
        $userAdmin->setRoles(['ROLE_SUPER_ADMIN']);

        $group = new ArrayCollection([$this->getReference('group-admin')]);
        $userAdmin->setGroups($group);

        $manager->persist($userAdmin);
        $manager->flush();

        $this->addReference('user-Admin', $userAdmin);
    }

    /**
     * Get the dependencies.
     */
    public function getDependencies()
    {
        return [LoadGroupData::class];
    }

    public static function getGroups(): array
    {
        return ['userGroup'];
    }
}
