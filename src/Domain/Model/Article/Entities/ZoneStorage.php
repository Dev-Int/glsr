<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Model\Article\Entities;

use Domain\Model\Common\VO\NameField;

final class ZoneStorage
{
    private string $name;
    private string $slug;

    public function __construct(NameField $name)
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }

    public static function create(NameField $name): self
    {
        return new self($name);
    }

    public function renameZone(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
