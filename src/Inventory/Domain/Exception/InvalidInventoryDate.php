<?php

namespace App\Inventory\Domain\Exception;

final class InvalidInventoryDate extends \DomainException
{
    /**
     * @var string
     */
    protected $message = 'The date must be the last day of month or week.';
}
