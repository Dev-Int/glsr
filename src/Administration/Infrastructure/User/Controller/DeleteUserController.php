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

use Administration\Domain\User\Command\DeleteUser;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class DeleteUserController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $uuid): Response
    {
        try {
            $this->commandBus->dispatch(new DeleteUser($uuid));
            $this->addFlash('success', 'User deleted started!');
        } catch (\RuntimeException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return new RedirectResponse($this->generateUrl('admin_user_index'));
    }
}
