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

namespace Core\Infrastructure\Common;

use Core\Domain\Protocol\Common\Command\CommandBusProtocol;
use Core\Domain\Protocol\Common\Command\CommandProtocol;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBusProtocol
{
    public MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    final public function dispatch(CommandProtocol $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
