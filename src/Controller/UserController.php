<?php
/**
 * UserController Controller of User entity.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <in@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * User Controller override EasyAdminBundle::AdminController.
 *
 * @category Controller
 */
class UserController extends BaseAdminController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function persistEntity($entity): void
    {
        if ($entity->getAdmin()) {
            $entity->setRoles(['ROLE_SUPER_ADMIN']);
        } elseif ($entity->getAssistant()) {
            $entity->setRoles(['ROLE_ADMIN']);
        }
        $this->encodePassword($entity);
        parent::persistEntity($entity);
    }

    public function updateEntity($entity): void
    {
        if ($entity->getAdmin()) {
            $entity->setRoles(['ROLE_SUPER_ADMIN']);
        } elseif ($entity->getAssistant()) {
            $entity->setRoles(['ROLE_ADMIN']);
        }
        $this->encodePassword($entity);
        parent::persistEntity($entity);
    }

    /**
     * Encode the password.
     *
     * @param UserInterface $user
     */
    public function encodePassword(UserInterface $user): void
    {
        if (!$user instanceof UserInterface) {
            return;
        }

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPassword())
        );
    }
}
