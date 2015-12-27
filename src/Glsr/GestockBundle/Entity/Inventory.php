<?php

/**
 * Entité Inventory.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inventory.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_inventory")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\InventoryRepository")
 */
class Inventory
{
    /**
     * @var int Id de l'inventaire
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idInv;

    /**
     * @var \DateTime Date de l'inventaire
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer Statut de l'inventaire
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;
    /**
     * @var float Montant de l'inventaire
     *
     * @ORM\Column(name="amount", type="decimal", scale=3, nullable=true)
     */
    private $amount;
    /**
     * @var text Fichier pdf de préparation de l'inventaire
     *
     * @ORM\Column(name="file", type="text", nullable=true)
     */
    private $file;
    
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->amount = 0.000;
        $this->active = 1;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->idInv;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Inventory
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set status.
     *
     * @param integer $status
     *
     * @return Inventory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return Inventory
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get idInv.
     *
     * @return int
     */
    public function getIdInv()
    {
        return $this->idInv;
    }
    /**
     * Set file.
     *
     * @param string $file
     *
     * @return Inventory
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add articles
     *
     * @param \Glsr\GestockBundle\Entity\InventoryArticle $articles
     * @return Inventory
     */
    public function addArticle(InventoryArticles $articles)
    {
        $this->articles[] = $articles;
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Glsr\GestockBundle\Entity\InventoryArticle $articles
     */
    public function removeArticle(InventoryArticles $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Inventory
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
}