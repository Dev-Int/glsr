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

namespace Administration\Infrastructure\Supplier\Controller;

use Administration\Domain\Supplier\Command\DeleteSupplier;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DeleteSupplierController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $uuid): Response
    {
        try {
            $this->commandBus->dispatch(new DeleteSupplier($uuid));

            return new Response('', Response::HTTP_NO_CONTENT);
        } catch (\RuntimeException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }
}
