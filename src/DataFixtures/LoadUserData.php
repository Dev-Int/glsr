<?php
/**
 * LoadUserData Données User de l'application GLSR.
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

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * LoadUser Data.
 *
 * @category DataFixtures
 */
class LoadUserData extends Fixture
{
    protected $encoder;
    protected $users = [
        [
            'username' => 'Admin',
            'email' => 'admin@locahost',
            'password' => 'adminadmin',
            'enable' => true,
            'admin' => true,
            'assistant' => false,
        ],
        [
            'username' => 'Assistant',
            'email' => 'assistant@locahost',
            'password' => 'assistant',
            'enable' => true,
            'admin' => false,
            'assistant' => true,
        ],
    ];

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
        foreach ($this->users as $key => $userData) {
            $userAdmin = new User();
            $password = $this->encoder->encodePassword($userAdmin, $userData['password']);
            $userAdmin->setUsername($userData['username'])
                ->setEmail($userData['email'])
                ->setEnabled($userData['enable'])
                ->setAdmin($userData['admin'])
                ->setAssistant($userData['assistant'])
                ->setPassword($password);

            $manager->persist($userAdmin);
            $order = $key + 1;
            $this->addReference('user-'.$order, $userAdmin);
        }
        $manager->flush();
    }
}
