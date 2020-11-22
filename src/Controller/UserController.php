<?php

namespace App\Controller;

use App\Entity\Staff\User2;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilder;

final class UserController extends BaseAdminController
{
    public function createUserEntityFormBuilder(User2 $entity, string $view): FormBuilder
    {
        $hierarchy = $this->getParameter('security.role_hierarchy.roles');

        // transform the role hierarchy in a single unique list
        $roles = array();
        array_walk_recursive($hierarchy, static function ($role) use (&$roles) {
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
}
