<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="gs_settings")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\SettingsRepository")
 */
class Settings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $inventory_style sort mode inventory
     *
     * @ORM\Column(name="inventory_style", type="string", length=50)
     */
    private $inventory_style;

    /**
     * @var string calculation of inventories and stocks
     *
     * @ORM\Column(name="calculation", type="string", length=50)
     */
    private $calculation;

    /**
     * @var datetime $first_inventory the first_inventory's date
     *
     * @ORM\Column(name="first_inventory", type="datetime")
     */
    private $first_inventory;

    /**
     * @var string $currency currency's choice
     *
     * @ORM\Column(name="currency", type="string", length=50)
     */
    private $currency;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inventory_style
     *
     * @param string $inventoryStyle
     * @return Settings
     */
    public function setInventoryStyle($inventoryStyle)
    {
        /**
         * @todo Possibilité d'insérer directement le mode de tri des inventaires : global, zonestorage
         */
        $this->inventory_style = $inventoryStyle;

        return $this;
    }

    /**
     * Get inventory_style
     *
     * @return string 
     */
    public function getInventoryStyle()
    {
        return $this->inventory_style;
    }

    /**
     * Set calculation
     *
     * @param string $calculation
     * @return Settings
     */
    public function setCalculation($calculation)
    {
        $this->calculation = $calculation;

        return $this;
    }

    /**
     * Get calculation
     *
     * @return string 
     */
    public function getCalculation()
    {
        return $this->calculation;
    }

    /**
     * Set first_inventory
     *
     * @param datetime $firstInventory
     * @return Settings
     */
    public function setFirstInventory(\Datetime $firstInventory)
    {
        $this->first_inventory = $firstInventory;

        return $this;
    }

    /**
     * Get first_inventory
     *
     * @return 
     */
    public function getFirstInventory()
    {
        return $this->first_inventory;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Settings
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
