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

namespace User\Application\Command;

use Core\Domain\Protocol\Common\Command\CommandInterface;

abstract class AbstractUser implements CommandInterface
{
    public ?string $uuid;
    private string $username;
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(
        string $username,
        string $email,
        string $password,
        array $roles = ['ROLE_USER'],
        ?string $uuid = null
    ) {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    final public function uuid(): ?string
    {
        return $this->uuid;
    }

    final public function username(): string
    {
        return $this->username;
    }

    final public function email(): string
    {
        return $this->email;
    }

    final public function password(): string
    {
        return $this->password;
    }

    final public function roles(): array
    {
        return $this->roles;
    }
}
