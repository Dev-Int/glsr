<?php

namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_settings")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\SettingsRepository")
 */
class Settings
{
    /**
     * @var int Id of setting
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string sort mode inventory
     *
     * @ORM\Column(name="inventory_style", type="string", length=50)
     */
    private $inventoryStyle;

    /**
     * @var string calculation of inventories and stocks
     *
     * @ORM\Column(name="calculation", type="string", length=50)
     */
    private $calculation;

    /**
     * @var \DateTimeImmutable the first inventory's date
     *
     * @ORM\Column(name="first_inventory", type="datetime_immutable", nullable=true)
     */
    private $firstInventory;

    /**
     * @var string currency's choice
     *
     * @ORM\Column(name="currency", type="string", length=50)
     */
    private $currency;

    public function getId(): int
    {
        return $this->id;
    }

    public function setInventoryStyle(string $inventoryStyle): self
    {
        /*
         * The method of sorting inventories : global, zonestorage
         */
        $this->inventoryStyle = $inventoryStyle;

        return $this;
    }

    public function getInventoryStyle(): string
    {
        return $this->inventoryStyle;
    }

    public function setCalculation(string $calculation): self
    {
        $this->calculation = $calculation;

        return $this;
    }

    public function getCalculation(): string
    {
        return $this->calculation;
    }

    public function setFirstInventory(\DateTimeImmutable $firstInventory): self
    {
        $this->firstInventory = $firstInventory;

        return $this;
    }

    public function getFirstInventory(): \DateTimeImmutable
    {
        return $this->firstInventory;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
