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

namespace Administration\Infrastructure\User\Handler;

use Administration\Domain\User\Command\EditUser;
use Administration\Domain\User\Model\User;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineUserRepository;
use Core\Domain\Model\User as UserInterface;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;
use Core\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineUserRepository as DoctrineUserInterfaceRepository;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditUserHandler implements CommandHandlerProtocol
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private DoctrineUserRepository $userRepository;
    private DoctrineUserInterfaceRepository $userInterfaceRepository;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        DoctrineUserRepository $userRepository,
        DoctrineUserInterfaceRepository $userInterfaceRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
        $this->userInterfaceRepository = $userInterfaceRepository;
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws NonUniqueResultException
     */
    public function __invoke(EditUser $command): void
    {
        $userToUpdate = $this->userInterfaceRepository->findOneByUuid($command->uuid()->toString());

        if (null === $userToUpdate) {
            throw new \DomainException('User provided does not exist!');
        }

        $user = $this->updateUser($command, $userToUpdate);
        $this->userRepository->update($user);
    }

    private function updateUser(EditUser $command, UserInterface $userInterface): User
    {
        if ($userInterface->username() !== $command->username()) {
            $userInterface->renameUser($command->username());
        }
        if ($userInterface->email() !== $command->email()) {
            $userInterface->changeEmail($command->email());
        }

        $userInterface->changePassword(
            $this->passwordEncoder->encodePassword(
                $userInterface,
                $command->password()
            )
        );

        if ($userInterface->roles() !== $command->roles()) {
            $userInterface->assignRoles($command->roles());
        }

        return $userInterface;
    }
}
