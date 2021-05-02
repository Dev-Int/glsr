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

namespace User\Application\Handler;

use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;
use User\Application\Command\DeleteUser as DeleteUserCommand;
use User\Infrastructure\Storage\RemoveUser;

final class DeleteUser implements CommandHandlerInterface
{
    private RemoveUser $removeUser;

    public function __construct(RemoveUser $removeUser)
    {
        $this->removeUser = $removeUser;
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->removeUser->remove($command->uuid());
    }
}
