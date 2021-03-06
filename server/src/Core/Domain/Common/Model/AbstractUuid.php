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

namespace Core\Domain\Common\Model;

use Core\Domain\Common\UuidProtocol;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractUuid implements UuidProtocol
{
    private UuidInterface $uuid;

    final public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return static
     */
    public static function generate()
    {
        try {
            return new static(Uuid::uuid4());
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot generate a new uuid.', 0, $exception);
        }
    }

    final public function toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @param UuidInterface $uuid
     */
    public static function fromUuid(object $uuid): UuidProtocol
    {
        if (!$uuid instanceof UuidInterface) {
            throw new \InvalidArgumentException('UuidInterface type excepted.');
        }

        return new static($uuid);
    }

    /**
     * @return static
     */
    public static function fromString(string $uuid)
    {
        return new static(Uuid::fromString($uuid));
    }
}
