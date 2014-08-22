<?php

/**
 * Settings Entité Settings
 * 
 * PHP Version 5
 * 
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: a3b89ab26b2fa582ff79abd0c0c760dd0b64c4e8
 * @link       https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings Entité Settings
 * 
 * @category   Entity
 * @package    Gestock
 * @subpackage Settings
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
    private $idSets;

    /**
     * @var string $inventory_style sort mode inventory
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
     * @var datetime $first_inventory the first inventory's date
     *
     * @ORM\Column(name="first_inventory", type="datetime", nullable=true)
     */
    private $firstInventory;

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
        return $this->idSets;
    }

    /**
     * Set inventory_style
     *
     * @param string $inventoryStyle Style d'inventaire
     * 
     * @return Settings
     */
    public function setInventoryStyle($inventoryStyle)
    {
        /**
         * @todo Possibilité d'insérer directement 
         * le mode de tri des inventaires : global, zonestorage
         */
        $this->inventoryStyle = $inventoryStyle;

        return $this;
    }

    /**
     * Get inventory_style
     *
     * @return string 
     */
    public function getInventoryStyle()
    {
        return $this->inventoryStyle;
    }

    /**
     * Set calculation
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
     * @param datetime $firstInventory Date du premier inventaire
     * 
     * @return Settings
     */
    public function setFirstInventory(\Datetime $firstInventory)
    {
        $this->firstInventory = $firstInventory;

        return $this;
    }

    /**
     * Get first_inventory
     *
     * @return datetime/null Date du premier inventaire
     */
    public function getFirstInventory()
    {
        return $this->firstInventory;
    }

    /**
     * Set currency
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
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
