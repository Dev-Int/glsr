<?php

/**
 * Entity User.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link https://github.com/Dev-Int/glsr
 */

namespace App\Entity\Staff;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * User Entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="fos_users")
 * @ORM\Entity(repositoryClass="App\Repository\Staff\UserRepository")
 */
class User extends BaseUser implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = $this->roles;

        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }

    public function isEqualTo(UserInterface $user)
    {
        $return = true;

        if ($this->password !== $user->getPassword()) {
            $return = false;
        }

        if ($this->username !== $user->getUsername()) {
            $return = false;
        }

        return $return;
    }
}
