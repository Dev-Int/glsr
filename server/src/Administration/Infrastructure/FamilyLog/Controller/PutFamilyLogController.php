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

namespace Administration\Infrastructure\FamilyLog\Controller;

use Administration\Domain\FamilyLog\Command\EditFamilyLog;
use Administration\Domain\FamilyLog\Model\VO\FamilyLogUuid;
use Core\Domain\Common\Model\VO\NameField;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutFamilyLogController extends AbstractController
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
        $familyLog = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        try {
            $command = new EditFamilyLog(
                FamilyLogUuid::fromString($uuid),
                NameField::fromString($familyLog['label']),
                $familyLog['parent']
            );
            $this->commandBus->dispatch($command);
        } catch (\DomainException $exception) {
            throw new \DomainException($exception->getMessage());
        }

        return new Response('FamilyLog update started!', Response::HTTP_FOUND);
    }
}
