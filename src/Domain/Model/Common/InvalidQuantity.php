<?php

declare(strict_types=1);

namespace Domain\Model\Common;

use DomainException;

final class InvalidQuantity extends DomainException
{
    protected $message = 'La quantité doit être un nombre.';
}
