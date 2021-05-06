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

namespace User\Domain\Model\VO;

use User\Domain\Exception\PasswordMustHaveDigitException;
use User\Domain\Exception\PasswordMustHaveSpecialCharactersException;
use User\Domain\Exception\PasswordMustHaveUpperException;
use User\Domain\Exception\PasswordMustReach8CharactersException;

final class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if (\strlen($password) < 8) {
            throw new PasswordMustReach8CharactersException();
        }
        if (!\preg_match('/([A-Z])/', $password)) {
            throw new PasswordMustHaveUpperException();
        }
        if (!\preg_match('/([\d])/', $password)) {
            throw new PasswordMustHaveDigitException();
        }
        if (!\preg_match('/([\-#$+_!()@])/', $password)) {
            throw new PasswordMustHaveSpecialCharactersException();
        }

        $this->password = $password;
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }

    public function value(): string
    {
        return $this->password;
    }
}
