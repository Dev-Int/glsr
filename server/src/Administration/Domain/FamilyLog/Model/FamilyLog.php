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

namespace Administration\Domain\FamilyLog\Model;

use Administration\Domain\FamilyLog\Model\VO\FamilyLogUuid;
use Core\Domain\Common\Model\VO\NameField;

final class FamilyLog
{
    private string $uuid;
    private string $label;
    private ?FamilyLog $parent = null;
    /**
     * @var FamilyLog[]|null
     */
    private ?array $children = null;
    private string $slug;
    private string $path;

    public function __construct(FamilyLogUuid $uuid, NameField $label, ?self $parent = null)
    {
        $this->uuid = $uuid->toString();
        $this->label = $label->getValue();
        $this->path = $label->slugify();
        $this->slug = $label->slugify();
        if (null !== $parent) {
            $this->parent = $parent;
            $this->parent->addChild($this);
            $this->path = $parent->slug() . ':' . $label->slugify();
            if (null !== $this->parent->parent) {
                $this->path = $this->parent->parent->slug() . ':' . $this->parent->slug() . ':' . $label->slugify();
            }
        }
    }

    public static function create(FamilyLogUuid $uuid, NameField $name, ?self $parent = null): self
    {
        return new self($uuid, $name, $parent);
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function parent(): ?self
    {
        return $this->parent;
    }

    public function children(): ?array
    {
        return $this->children;
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
            return [$this->label => $arrayChildren];
        }

        foreach ($this->children as $child) {
            if (null !== $this->hasChildren($child)) {
                $arrayChildren[$child->label] = $this->hasChildren($child);
            } else {
                $arrayChildren[] = $child->label;
            }
        }

        return [$this->label => $arrayChildren];
    }

    private function hasChildren(self $familyLog): ?array
    {
        if (null !== $familyLog->children) {
            return \array_map(static function (self $child) {
                return $child->label;
            }, $familyLog->children);
        }

        return null;
    }

    private function addChild(self $child): void
    {
        $this->children[] = $child;
    }
}
