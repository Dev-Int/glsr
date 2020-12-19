<?php

namespace Administration\Domain\User\Model;

use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;

final class User
{
    private string $uuid;
    private string $username;
    private string $email;
    private string $password;
    private array $roles;

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

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function renameUser(NameField $username): self
    {
        $this->username = $username->getValue();

        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function changeEmail(EmailField $email): self
    {
        $this->email = $email->getValue();

        return $this;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function changePassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function assignRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
