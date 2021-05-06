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

namespace User\Domain\Model;

use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\ResourceUuid;
use User\Domain\Model\VO\Password;

class User
{
    private ResourceUuid $uuid;
    private NameField $username;
    private EmailField $email;
    private Password $password;
    private array $roles;

    public function __construct(
        ResourceUuid $uuid,
        NameField $username,
        EmailField $email,
        Password $password,
        array $roles = []
    ) {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public static function create(
        ResourceUuid $uuid,
        NameField $username,
        EmailField $email,
        Password $password,
        array $roles = []
    ): self {
        return new self($uuid, $username, $email, $password, $roles);
    }

    final public function uuid(): ResourceUuid
    {
        return $this->uuid;
    }

    final public function username(): NameField
    {
        return $this->username;
    }

    final public function renameUser(NameField $username): self
    {
        $this->username = $username;

        return $this;
    }

    final public function email(): EmailField
    {
        return $this->email;
    }

    final public function changeEmail(EmailField $email): self
    {
        $this->email = $email;

        return $this;
    }

    final public function password(): Password
    {
        return $this->password;
    }

    final public function changePassword(Password $password): self
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
