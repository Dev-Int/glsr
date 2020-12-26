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

namespace Administration\Domain\User\Model;

use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Protocol\Common\UuidProtocol;

class User
{
    protected string $uuid;
    protected string $username;
    protected string $email;
    protected string $password;
    protected array $roles;

    public function __construct(
        UserUuid $uuid,
        NameField $username,
        EmailField $email,
        string $password,
        array $roles = []
    ) {
        $this->uuid = $uuid->toString();
        $this->username = $username->getValue();
        $this->email = $email->getValue();
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

    final public function uuid(): UuidProtocol
    {
        return UserUuid::fromString($this->uuid);
    }

    final public function username(): string
    {
        return $this->username;
    }

    final public function renameUser(NameField $username): self
    {
        $this->username = $username->getValue();

        return $this;
    }

    final public function email(): EmailField
    {
        return new EmailField($this->email);
    }

    final public function changeEmail(EmailField $email): self
    {
        $this->email = $email->getValue();

        return $this;
    }

    final public function password(): string
    {
        return $this->password;
    }

    final public function changePassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    final public function roles(): array
    {
        if ([] === $this->roles) {
            $this->roles = ['ROLE_USER'];
        }

        return $this->roles;
    }

    final public function assignRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
