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

namespace Core\Domain\Common\Model\Exception;

final class InvalidPhone extends \DomainException
{
    /** @var string */
    protected $message = 'Le numéro saisie n\'est pas valide.';
}
