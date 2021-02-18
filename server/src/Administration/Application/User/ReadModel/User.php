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

final class User
{
    public string $uuid;
    public string $username;
    public string $email;
    public ?string $password;
    public array $roles;

    public function __construct(
        string $uuid,
        string $username,
        string $email,
        array $roles,
        ?string $password = null
    ) {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function uuid(): ?string
    {
        return $this->uuid;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function roles(): array
    {
        return $this->roles;
    }
}
