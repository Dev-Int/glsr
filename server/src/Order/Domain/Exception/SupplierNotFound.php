<?php

declare(strict_types=1);

namespace Order\Domain\Exception;

final class SupplierNotFound extends \Exception
{
    /** @var string $message */
    protected $message = "Supplier with this name does not exist";
}
