<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Administration\Infrastructure\User\Controller;

use Administration\Application\User\ReadModel\User;
use Administration\Infrastructure\User\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetEditUserController extends AbstractController
{
    public function __invoke(User $user): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('admin_user_update', ['uuid' => $user->getUuid()]),
            'method' => 'PUT',
        ]);

        return $this->render('Administration/User/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
