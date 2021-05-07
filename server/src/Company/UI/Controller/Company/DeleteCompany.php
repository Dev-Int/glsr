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

namespace Company\UI\Controller\Company;

use Company\Application\Command\DeleteCompany as DeleteCompanyCommand;
use Core\Infrastructure\Common\MessengerCommandBus;
use Core\Infrastructure\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteCompany
{
    private MessengerCommandBus $commandBus;
    private JsonResponse $jsonResponse;

    public function __construct(MessengerCommandBus $commandBus, JsonResponse $jsonResponse)
    {
        $this->commandBus = $commandBus;
        $this->jsonResponse = $jsonResponse;
    }

    public function __invoke(string $uuid): Response
    {
        $this->commandBus->dispatch(new DeleteCompanyCommand($uuid));

        return $this->jsonResponse->response('', Response::HTTP_NO_CONTENT);
    }
}
