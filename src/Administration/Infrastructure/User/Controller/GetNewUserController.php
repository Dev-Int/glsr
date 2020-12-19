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

use Administration\Infrastructure\User\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetNewUserController extends AbstractController
{
    public function __invoke(): Response
    {
        $form = $this->createForm(UserType::class, null, [
            'action' => $this->generateUrl('admin_user_create'),
        ]);

        return $this->render('Administration/User/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
