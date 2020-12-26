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

use Administration\Domain\User\Command\CreateUser;
use Administration\Infrastructure\User\Form\UserType;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostUserController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $user = $request->get('user');
        if ($user['password']['first'] !== $user['password']['second']) {
            throw new \DomainException('The first and second password must match!');
        }

        try {
            $command = new CreateUser(
                NameField::fromString($user['username']),
                EmailField::fromString($user['email']),
                $user['password']['first'],
                $user['roles']
            );
            $this->commandBus->dispatch($command);
        } catch (\DomainException $exception) {
            $form = $this->createForm(UserType::class, $user, [
                'action' => $this->generateUrl('admin_user_create'),
            ]);
            $this->addFlash('error', $exception->getMessage());

            return $this->render('Administration/User/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $this->addFlash('success', 'User created start!');

        return new RedirectResponse($this->generateUrl('admin_user_index'));
    }
}
