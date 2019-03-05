<?php

/**
 * Entity Settings.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace  App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings Entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_settings")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\SettingsRepository")
 */
class Settings
{
    /**
     * @var int $cfId Id of the configuration
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cfId;

    /**
     * @var string $inventoryStyle Sort mode inventory
     *
     * @ORM\Column(name="inventory_style", type="string", length=50)
     */
    private $inventoryStyle;

    /**
     * @var string $calculation Inventory calculation method
     *
     * @ORM\Column(name="calculation", type="string", length=50)
     */
    private $calculation;

    /**
     * @var string $currency Currency format of the application
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
        return $this->cfId;
    }

    /**
     * Set inventoryStyle.
     *
     * @param string $inventoryStyle Sort mode inventory
     *
     * @return Settings
     */
    public function setInventoryStyle($inventoryStyle)
    {
        /*
         * the method of sorting inventories : global, zonestorage
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
