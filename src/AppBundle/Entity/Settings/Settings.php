<?php

/**
 * Entité Settings.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings Entité Settings.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_settings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Settings\SettingsRepository")
 */
class Settings
{
    /**
     * @var int Id de la configuration
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
     * @param string $inventoryStyle Style d'inventaire
     *
     * @return Settings
     */
    public function setInventoryStyle($inventoryStyle)
    {
        /*
         * le mode de tri des inventaires : global, zonestorage
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
     * @param string $calculation Mode de calcul de l'inventaire
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
     * @param string $currency Format monétaire de l'application
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