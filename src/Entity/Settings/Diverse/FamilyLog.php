<?php

namespace App\Entity\Settings\Diverse;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="app_familylog")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\MaterializedPathRepository")
 * @Gedmo\Tree(type="materializedPath")
 */
class FamilyLog
{
    /**
     * @var int Logistic family id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\TreePath
     * @ORM\Column(length=3000, nullable=true)
     */
    private $path;

    /**
     * @Gedmo\TreePathSource
     * @var string Logistic family name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Slug name
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\FamilyLog", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Settings\Diverse\FamilyLog", mappedBy="parent")
     */
    private $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setParent(FamilyLog $parent = null): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent(): ?FamilyLog
    {
        return $this->parent;
    }

    public function addChild(FamilyLog $children): self
    {
        $this->children[] = $children;

        return $this;
    }

    public function removeChild(FamilyLog $children): void
    {
        $this->children->removeElement($children);
    }

    /**
     * @return FamilyLog[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Allows hierarchy display.
     */
    public function getIndentedName(): string
    {
        $return = '';
        if ($this->parent !== null) {
            if ($this->level === 2) {
                $return = '|-- ' . $this->name;
            } elseif ($this->level === 3) {
                $return = '|-- |-- ' . $this->name;
            }
        } else {
            $return = '| ' . $this->name;
        }

        return $return;
    }
}
