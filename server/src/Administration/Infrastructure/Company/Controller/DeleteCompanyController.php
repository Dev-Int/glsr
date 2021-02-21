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

namespace Administration\Infrastructure\Company\Controller;

use Administration\Domain\Company\Command\DeleteCompany;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DeleteCompanyController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $uuid): Response
    {
        try {
            $this->commandBus->dispatch(new DeleteCompany($uuid));

            $response = new Response();
            $response->setStatusCode(Response::HTTP_NO_CONTENT);

            return $response;
        } catch (\RuntimeException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }
}