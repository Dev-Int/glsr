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

namespace Administration\Application\User\ReadModel;

use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    public ?string $uuid;
    public string $username;
    public string $email;
    public string $password;
    public array $roles;

    public function __construct(
        string $username,
        string $email,
        string $password,
        array $roles = ['user'],
        ?string $uuid = null
    ) {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return \array_unique($roles);
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
