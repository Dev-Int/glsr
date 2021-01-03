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

namespace Core\Domain\Model;

use Administration\Domain\User\Model\User as UserDomain;
use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends UserDomain implements UserInterface
{
    public static function create(
        UserUuid $uuid,
        NameField $username,
        EmailField $email,
        string $password,
        array $roles = []
    ): self {
        return new self($uuid, $username, $email, $password, $roles);
    }

    public function getUuid(): string
    {
        return $this->uuid()->toString();
    }

    public function getUsername(): string
    {
        return $this->username();
    }

    public function getEmail(): string
    {
        return $this->email()->getValue();
    }

    public function getPassword(): string
    {
        return $this->password();
    }

    public function getRoles(): array
    {
        return \array_unique($this->roles());
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @see AuthenticationSuccessResponseListener::onAuthenticationSuccessResponse
     */
    public function getProfileInfos(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
        ];
    }
}
