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

namespace Administration\Domain\User\Command;

use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Protocol\Common\Command\CommandInterface;

final class EditUser implements CommandInterface
{
    private UserUuid $uuid;
    private NameField $username;
    private EmailField $email;
    private string $password;
    private array $roles;

    public function __construct(
        UserUuid $uuid,
        NameField $username,
        EmailField $email,
        string $password,
        array $roles = []
    ) {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function uuid(): UserUuid
    {
        return $this->uuid;
    }

    public function username(): NameField
    {
        return $this->username;
    }

    public function email(): EmailField
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function roles(): array
    {
        return $this->roles;
    }
}
