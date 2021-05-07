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

use Core\Domain\Common\Command\CommandHandlerInterface;
use User\Application\Command\EditUser as EditUserCommand;
use User\Application\Factory\CreateUser as CreateUserFactory;
use User\Domain\Storage\SaveUser;

final class EditUser implements CommandHandlerInterface
{
    private SaveUser $saveUser;
    private CreateUserFactory $createUser;

    public function __construct(
        SaveUser $saveUser,
        CreateUserFactory $createUser
    ) {
        $this->saveUser = $saveUser;
        $this->createUser = $createUser;
    }

    public function __invoke(EditUserCommand $command): void
    {
        $this->saveUser->save($this->createUser->createUser($command));
    }
}
