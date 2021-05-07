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

namespace Core\Controller;

use Core\Domain\Common\Command\CommandInterface;
use Core\Domain\Common\Query\QueryInterface;
use Core\Infrastructure\Common\MessengerCommandBus;
use Core\Infrastructure\Common\MessengerQueryBus;
use Core\Infrastructure\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController
{
    private MessengerCommandBus $commandBus;
    private JsonResponse $jsonResponse;
    private SerializerInterface $serializer;
    private MessengerQueryBus $queryBus;

    public function __construct(
        MessengerCommandBus $commandBus,
        JsonResponse $jsonResponse,
        SerializerInterface $serializer,
        MessengerQueryBus $queryBus
    ) {
        $this->commandBus = $commandBus;
        $this->jsonResponse = $jsonResponse;
        $this->serializer = $serializer;
        $this->queryBus = $queryBus;
    }

    protected function serialize(object $object, array $context = [], string $format = 'json'): string
    {
        return $this->serializer->serialize($object, $format, $context);
    }

    protected function deserialize(string $payload, string $type, string $format = 'json'): object
    {
        return $this->serializer->deserialize($payload, $type, $format);
    }

    protected function response(string $bodyResponse, int $statusCode = 201): Response
    {
        return $this->jsonResponse->response($bodyResponse, $statusCode);
    }

    protected function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function handle(QueryInterface $command): ?object
    {
        return $this->queryBus->handle($command);
    }
}
