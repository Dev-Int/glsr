<?php

declare(strict_types=1);

namespace Domain\Model\Common;

use Cocur\Slugify\Slugify;

final class Name
{
    /**
     * @var string
     */
    private $name;

    /**
     * Name constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (strlen($name) > 255) {
            throw new StringExceeds255Characters();
        }

        $this->name = $name;
    }

    /**
     * @param string $name
     * @return Name
     */
    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function getValue(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return string
     */
    public function slugify(string $name): string
    {
        $slugify = new Slugify();

        return $slugify->slugify($name);
    }
}
