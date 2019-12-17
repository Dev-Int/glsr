<?php

declare(strict_types=1);

namespace Domain\Model\Common;

use Zend\EventManager\Exception\DomainException;

final class StringExceeds255Characters extends DomainException
{
    protected $message = 'Le titre est trop long. Vous ne devriez pas exéder 255 caractères';
}