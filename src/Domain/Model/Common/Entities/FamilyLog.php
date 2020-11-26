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

namespace Domain\Model\Common\Entities;

use Domain\Model\Common\VO\NameField;

final class FamilyLog
{
    private string $name;
    private ?FamilyLog $parent = null;
    /**
     * @var FamilyLog[]|null
     */
    private ?array $children = null;
    private string $slug;
    private string $path;

    public function __construct(NameField $name, ?self $parent = null)
    {
        $this->name = $name->getValue();
        $this->path = $name->slugify();
        $this->slug = $name->slugify();
        if (null !== $parent) {
            $this->parent = $parent;
            $this->parent->addChild($this);
            $this->path = $parent->slug() . ':' . $name->slugify();
            if (null !== $this->parent->parent) {
                $this->path = $this->parent->parent->slug() . ':' . $this->parent->slug() . ':' . $name->slugify();
            }
        }
    }

    public static function create(NameField $name, ?self $parent = null): self
    {
        return new self($name, $parent);
    }

    public function parent(): ?self
    {
        return $this->parent;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function parseTree(): array
    {
        $arrayChildren = [];
        if (null === $this->children) {
            return [$this->name => $arrayChildren];
        }

        foreach ($this->children as $child) {
            if (null !== $this->hasChildren($child)) {
                $arrayChildren[$child->name] = $this->hasChildren($child);
            } else {
                $arrayChildren[] = $child->name;
            }
        }

        return [$this->name => $arrayChildren];
    }

    private function hasChildren(self $familyLog): ?array
    {
        if (null !== $familyLog->children) {
            return \array_map(static function ($child) {
                return $child->name;
            }, $familyLog->children);
        }

        return null;
    }

    private function addChild(self $child): void
    {
        $this->children[] = $child;
    }
}
