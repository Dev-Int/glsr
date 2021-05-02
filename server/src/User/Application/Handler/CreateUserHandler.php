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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use User\Application\Command\CreateUser as CreateUserCommand;
use User\Application\Factory\CreateUser as CreateUserFactory;
use User\Domain\Exception\UserAlreadyExistException;
use User\Domain\Model\VO\Password;
use User\Infrastructure\Doctrine\Entity\User;
use User\Infrastructure\Storage\ReadUser;
use User\Infrastructure\Storage\SaveUser;

final class CreateUserHandler implements CommandHandlerInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private ReadUser $readUser;
    private SaveUser $saveUser;
    private CreateUserFactory $createUserFactory;

    public function __construct(
        ReadUser $readUser,
        SaveUser $saveUser,
        CreateUserFactory $createUserFactory,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->readUser = $readUser;
        $this->saveUser = $saveUser;
        $this->createUserFactory = $createUserFactory;
    }

    public function __invoke(CreateUserCommand $command): void
    {
        if ($this->readUser->existsWithUsername($command->username())
            || $this->readUser->existsWithEmail($command->email())
        ) {
            throw new UserAlreadyExistException();
        }

        $user = $this->createUserFactory->createUser($command);

        $userSymfony = User::fromModel($user);
        $passwordEncoded = $this->passwordEncoder->encodePassword(
            $userSymfony,
            $command->password()
        );
        $user->changePassword(Password::fromString($passwordEncoded));

        $this->saveUser->save($user);
    }
}
