<?php
/**
 * Entité Inventory
 * 
 * PHP Version 5
 * 
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: 66c30ad5658ae2ccc5f74e6258fa4716d852caf9
 * @link       https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inventory
 * 
 * @category   Entity
 * @package    Gestock
 * @subpackage Inventory
 *
 * @ORM\Table(name="gs_inventory")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\InventoryRepository")
 */
class Inventory
{
    /**
     * @var integer $id Id de l'inventaire
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idInv;

    /**
     * @var \DateTime $date Date de l'inventaire
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean $active Activé/Désactivé
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var float $amount Montant de l'inventaire
     *
     * @ORM\Column(name="amount", type="decimal", scale=3, nullable=true)
     */
    private $amount;

    /**
     * @var text $file Fichier de l'inventaire
     * 
     * @ORM\Column(name="file", type="text", nullable=true)
     */
    private $file;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->idInv;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Inventory
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * is active
     *
     * @param boolean $active
     * @return Inventory
     */
    public function isActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Inventory
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get idInv
     *
     * @return integer 
     */
    public function getIdInv()
    {
        return $this->idInv;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return Inventory
     */
    public function setFile($file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
}
