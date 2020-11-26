<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Model\Common\Exception;

final class InvalidQuantity extends \DomainException
{
    /** @var string */
    protected $message = 'La quantité doit être un nombre.';
}
