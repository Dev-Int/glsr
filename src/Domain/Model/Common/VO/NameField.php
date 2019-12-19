<?php

declare(strict_types=1);

namespace Domain\Model\Common\VO;

use Cocur\Slugify\Slugify;
use Domain\Model\Common\StringExceeds255Characters;

final class NameField
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
     * @return NameField
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
     * @return string
     */
    public function slugify(): string
    {
        $slugify = new Slugify();

        return $slugify->slugify($this->name);
    }
}
