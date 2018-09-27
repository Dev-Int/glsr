<?php
/**
 * Entité Inventory.
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
namespace AppBundle\Entity\Stocks;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Stocks\InventoryArticles;

/**
 * Inventory
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_inventory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Stocks\InventoryRepository")
 */
class Inventory
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;


    /**
     * @var float Montant de l'inventaire
     *
     * @ORM\Column(name="amount", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Stocks\InventoryArticles", mappedBy="inventory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->date = new \DateTime();
        $this->amount = 0.000;
        $this->status = 1;
    }

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
     * Set date
     *
     * @param \DateTime $date
     * @return Inventory
     */
    public function setDate(\DateTime $date)
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
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Inventory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add articles
     *
     * @param \AppBundle\Entity\Stocks\InventoryArticles $articles
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
     * @param \AppBundle\Entity\Stocks\InventoryArticles $articles
     */
    public function removeArticle(InventoryArticles $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}