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

namespace Company\UI\Controller;

use Company\Application\Command\EditCompany as EditCompanyCommand;
use Core\Infrastructure\Common\MessengerCommandBus;
use Core\Infrastructure\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class EditCompany
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

    /**
     * @throws \JsonException
     */
    public function __invoke(Request $request, string $uuid): Response
    {
        /** @var EditCompanyCommand $companyCommand */
        $companyCommand = $this->serializer->deserialize($request->getContent(), EditCompanyCommand::class, 'json');
        $companyCommand->uuid = $uuid;

        $this->commandBus->dispatch($companyCommand);

        return $this->jsonResponse->response('Company update started!', Response::HTTP_FOUND);
    }
}
