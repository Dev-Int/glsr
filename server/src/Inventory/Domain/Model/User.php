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

namespace Inventory\Domain\Model;

final class User
{
    private string $username;
    private string $email;
    private string $role;

    public function __construct(string $username, string $email, string $role)
    {
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
    }

    public static function create(string $username, string $email, string $role): self
    {
        return new self($username, $email, $role);
    }

    public function role(): string
    {
        return $this->role;
    }
}
