<?php

namespace App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="app_unit")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\UnitRepository")
 */
class Unit
{
    /**
     * @var int Id of unit
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Name of unit
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Abbreviation of the unit
     *
     * @ORM\Column(name="abbr", type="string", length=50)
     */
    private $abbr;

    /**
     * @var string Slug name
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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

    public function setAbbr(string $abbr): self
    {
        $this->abbr = $abbr;

        return $this;
    }

    public function getAbbr(): string
    {
        return $this->abbr;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function __toString(): string
    {
        return $this->abbr;
    }
}
