<?php

/**
 * Entity Settings.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings Entity.
 *
 * @category Entity
 *
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
     * @var \DateTime the first inventory's date
     *
     * @ORM\Column(name="first_inventory", type="datetime", nullable=true)
     */
    private $firstInventory;

    /**
     * @var string currency's choice
     *
     * @ORM\Column(name="currency", type="string", length=50)
     */
    private $currency;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inventoryStyle.
     *
     * @param string $inventoryStyle Inventory style
     *
     * @return Settings
     */
    public function setInventoryStyle($inventoryStyle)
    {
        /*
         * The method of sorting inventories : global, zonestorage
         */
        $this->inventoryStyle = $inventoryStyle;

        return $this;
    }

    /**
     * Get inventory_style.
     *
     * @return string
     */
    public function getInventoryStyle()
    {
        return $this->inventoryStyle;
    }

    /**
     * Set calculation.
     *
     * @param string $calculation Inventory calculation method
     *
     * @return Settings
     */
    public function setCalculation($calculation)
    {
        $this->calculation = $calculation;

        return $this;
    }

    /**
     * Get calculation.
     *
     * @return string
     */
    public function getCalculation()
    {
        return $this->calculation;
    }

    /**
     * Set first_inventory.
     *
     * @param \DateTime $firstInventory Date of the first inventory
     *
     * @return Settings
     */
    public function setFirstInventory(\DateTime $firstInventory)
    {
        $this->firstInventory = $firstInventory;

        return $this;
    }

    /**
     * Get first_inventory.
     *
     * @return \DateTime Date of the first inventory
     */
    public function getFirstInventory()
    {
        return $this->firstInventory;
    }

    /**
     * Set currency.
     *
     * @param string $currency Currency format of the application
     *
     * @return Settings
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
