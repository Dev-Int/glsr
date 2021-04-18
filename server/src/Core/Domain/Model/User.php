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

use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;

class User
{
    private UserUuid $uuid;
    private NameField $username;
    private EmailField $email;
    private string $password;
    private array $roles;

    public function __construct(UserUuid $uuid, NameField $username, EmailField $email, string $password, array $roles)
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public static function create(
        UserUuid $uuid,
        NameField $username,
        EmailField $email,
        string $password,
        array $roles = []
    ): self {
        return new self($uuid, $username, $email, $password, $roles);
    }

    public function uuid(): string
    {
        return $this->uuid->toString();
    }

    public function getUsername(): string
    {
        return $this->username->getValue();
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return \array_unique($this->roles);
    }
}
