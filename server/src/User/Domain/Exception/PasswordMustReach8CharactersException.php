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

namespace User\Domain\Exception;

use Core\Domain\Exception\ApiExceptionInterface;

final class PasswordMustReach8CharactersException extends \DomainException implements ApiExceptionInterface
{
    public function __construct()
    {
        parent::__construct('The password must be at least 8 characters long');
    }
}
