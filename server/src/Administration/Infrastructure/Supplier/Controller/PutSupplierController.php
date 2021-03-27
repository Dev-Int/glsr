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

use Administration\Domain\Supplier\Command\EditSupplier;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutSupplierController extends AbstractController
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
        $supplier = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        try {
            $command = new EditSupplier(
                ContactUuid::fromString($uuid),
                NameField::fromString($supplier['name']),
                $supplier['address'],
                $supplier['zipCode'],
                $supplier['town'],
                $supplier['country'],
                PhoneField::fromString($supplier['phone']),
                PhoneField::fromString($supplier['facsimile']),
                EmailField::fromString($supplier['email']),
                $supplier['contact_name'],
                PhoneField::fromString($supplier['cellphone']),
                $supplier['familyLogId'],
                $supplier['delayDelivery'],
                $supplier['orderDays']
            );
            $this->commandBus->dispatch($command);
        } catch (\DomainException $exception) {
            throw new \DomainException($exception->getMessage());
        }

        return new Response('Supplier update started!', Response::HTTP_FOUND);
    }
}
