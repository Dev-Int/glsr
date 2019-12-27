<?php

declare(strict_types=1);

namespace Domain\Model\Common\Entities;

use Domain\Model\Common\VO\NameField;

class FamilyLog
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $parent = null;

    /**
     * @var array
     */
    private $children;
    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $path;

    /**
     * FamilyLog constructor.
     *
     * @param NameField      $name
     * @param FamilyLog|null $parent
     */
    public function __construct(NameField $name, ?FamilyLog $parent = null)
    {
        $this->name = $name->getValue();
        $this->path = $name->slugify();
        $this->slug = $name->slugify();
        if (null !== $parent) {
            $this->parent = $parent;
            $this->parent->addChild($name->getValue());
            $this->path = $parent->slug().'_'.$name->slugify();
        }
    }

    public static function create(NameField $name, ?FamilyLog $parent = null): self
    {
        return new self($name, $parent);
    }

    final public function path(): string
    {
        return $this->path;
    }

    final public function slug(): string
    {
        return $this->slug;
    }

    final public function parseTree(): array
    {
        return [
            $this->name => $this->children,
        ];
    }

    private function addChild(string $child): void
    {
        $this->children[] = $child;
    }
}
