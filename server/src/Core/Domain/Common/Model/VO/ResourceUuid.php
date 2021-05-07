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

namespace Core\Domain\Common\Model\VO;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ResourceUuid implements ResourceUuidInterface
{
    private UuidInterface $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        try {
            return new self(Uuid::uuid4());
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot generate a new uuid.', 0, $exception);
        }
    }

    public static function fromUuid(ResourceUuidInterface $uuid): string
    {
        if (!$uuid instanceof ResourceUuidInterface) {
            throw new \InvalidArgumentException('ResourceUuidInterface type excepted.');
        }

        return $uuid->toString();
    }

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }
}
