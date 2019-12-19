<?php

declare(strict_types=1);

namespace Domain\Model\Common;

use DomainException;

final class InvalidEmail extends DomainException
{
    protected $message = 'L\'adresse mail saisie n\'est pas valide.';
}
