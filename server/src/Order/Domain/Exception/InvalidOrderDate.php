<?php

namespace Order\Domain\Exception;

class InvalidOrderDate extends \DomainException
{
    /** @var string */
    protected $message = 'The date must be valid with the supplier prerequisite';
}
