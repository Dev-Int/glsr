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

namespace User\UI\Controller;

use Core\Infrastructure\Common\MessengerCommandBus;
use Core\Infrastructure\Response\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use User\Application\Command\CreateUser as CreateUserCommand;

class CreateUser extends AbstractController
{
    private MessengerCommandBus $commandBus;
    private JsonResponse $jsonResponse;
    private SerializerInterface $serializer;

    public function __construct(
        MessengerCommandBus $commandBus,
        JsonResponse $jsonResponse,
        SerializerInterface $serializer
    ) {
        $this->commandBus = $commandBus;
        $this->jsonResponse = $jsonResponse;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): Response
    {
        /** @var CreateUserCommand $userCommand */
        $userCommand = $this->serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');

        $this->commandBus->dispatch($userCommand);

        return $this->jsonResponse->response('User create started!', Response::HTTP_CREATED);
    }
}
