<?php

declare(strict_types=1);

namespace App\Inventory\Domain;

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
