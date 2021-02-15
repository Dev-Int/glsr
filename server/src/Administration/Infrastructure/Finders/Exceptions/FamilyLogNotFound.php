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

namespace Administration\Infrastructure\Finders\Exceptions;

class FamilyLogNotFound extends \RuntimeException implements AggregateNotFound
{
    public function __construct()
    {
        parent::__construct('FamilyLog not found');
    }
}
