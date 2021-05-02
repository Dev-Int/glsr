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

namespace User\Infrastructure\Storage;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use User\Domain\Model\User as UserModel;
use User\Domain\Model\VO\Password;
use User\Infrastructure\Doctrine\Repository\UserRepository;

class UpdateUser
{
    private UserRepository $userRepository;
    private ReadUser $readUser;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        ReadUser $readUser,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->readUser = $readUser;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function update(UserModel $userModel): void
    {
        $userEntity = $this->readUser->findOneByUuid($userModel->uuid()->__toString());

        if ($this->passwordEncoder->isPasswordValid($userEntity, $userModel->password()->value())) {
            $encodedPassword = $this->passwordEncoder->encodePassword($userEntity, $userModel->password()->value());
            $userModel->changePassword(Password::fromString($encodedPassword));
        }

        $userEntity->update($userModel);

        $this->userRepository->flush();
    }
}
