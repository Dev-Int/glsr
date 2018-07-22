<?php

/**
 * UserController Controller of User entity.
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

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * User Controller override EasyAdminBundle::AdminController
 *
 * @category Controller
 */
class UserController extends BaseAdminController
{
    public function createUserEntityFormBuilder($entity, $view)
    {
        $hierarchy = $this->container->getParameter('security.role_hierarchy.roles');

        // transform the role hierarchy in a single unique list
        $roles = array();
        array_walk_recursive($hierarchy, function ($role) use (&$roles) {
            $roles[$role] = $role;
        });

        $formBuilder = $this->createEntityFormBuilder($entity, $view);
        $formBuilder->
            add('roles', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'placeholder' => 'Choice a role',
                'choices' => $roles,
            ]);

        return $formBuilder;
    }

    public function updateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::updateEntity($user);
    }
}
