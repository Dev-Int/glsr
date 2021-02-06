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

use Administration\Domain\User\Command\EditUser;
use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutUsersController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(Request $request, string $uuid): Response
    {
        $user = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        try {
            $command = new EditUser(
                UserUuid::fromString($uuid),
                NameField::fromString($user['username']),
                EmailField::fromString($user['email']),
                $user['password'],
                $user['roles']
            );
            $this->commandBus->dispatch($command);
        } catch (\DomainException $exception) {
            throw new \DomainException($exception->getMessage());
        }

        return new Response('User updated started!', Response::HTTP_ACCEPTED);
    }
}
