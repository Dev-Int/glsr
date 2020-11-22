<?php

namespace App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="app_zonestorage")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\ZoneStorageRepository")
 */
class ZoneStorage
{
    /**
     * @var int Id of the storage area
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Name of the storage area
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Slug name
     *
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

    public function __toString(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
