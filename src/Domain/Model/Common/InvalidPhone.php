<?php

declare(strict_types=1);

namespace Domain\Model\Common;

use DomainException;

final class InvalidPhone extends DomainException
{
    protected $message = 'Le numéro saisie n\'est pas valide.';
}
