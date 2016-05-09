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
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\InventoryArticles;

/**
 * Inventory
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_inventory")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\InventoryRepository")
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
     * @var boolean
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
     * @var string
     *
     * @ORM\Column(name="file", type="text", nullable=true)
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\InventoryArticles", mappedBy="inventory")
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

    /**
     * Set amount
     *
     * @param string $amount
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
     * @return string 
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
     * @param \AppBundle\Entity\InventoryArticles $articles
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
     * @param \AppBundle\Entity\InventoryArticles $articles
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
}
