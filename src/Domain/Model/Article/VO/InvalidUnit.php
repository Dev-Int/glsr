<?php

declare(strict_types=1);

namespace Domain\Model\Article\VO;

use DomainException;

final class InvalidUnit extends DomainException
{
    protected $message = 'L\'unité ne correspond pas à une unité valide.';
}
