<?php

/**
 * Entité InventoryArticles.
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

/**
 * InventoryArticles
 *
 * @ORM\Table(name="gs_inventory_articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Stocks\InventoryArticlesRepository")
 */
class InventoryArticles
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stocks\Inventory", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventory;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var decimal Quantité en stock
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="realstock", type="decimal", precision=7, scale=3, options={"default" = 0})
     */
    private $realstock;

    /**
     * @var string|\AppBundle\Entity\Settings\Diverse\Unit Unité de stockage
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Diverse\Unit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitStorage;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $price;

    /**
     * @var string $zoneStorage Zone de stockage
     *
     * @ORM\Column(name="zoneStorage", type="string", length=255, nullable=true)
     */
    private $zoneStorage;


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
     * Set inventory
     *
     * @param \AppBundle\Entity\Stocks\Inventory $inventory
     * @return InventoryArticles
     */
    public function setInventory(\AppBundle\Entity\Stocks\Inventory $inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return \AppBundle\Entity\Stocks\Inventory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Settings\Article $article
     * @return InventoryArticles
     */
    public function setArticle(\AppBundle\Entity\Settings\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Settings\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set realstock
     *
     * @param string $realstock
     * @return InventoryArticles
     */
    public function setRealstock($realstock)
    {
        $this->realstock = $realstock;

        return $this;
    }

    /**
     * Get realstock
     *
     * @return string
     */
    public function getRealstock()
    {
        return $this->realstock;
    }

    /**
     * Set Price
     *
     * @param string $price
     * @return InventoryArticles
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get Price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param decimal $quantity
     * @return InventoryArticles
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return decimal
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unitStorage
     *
     * @param null|\AppBundle\Entity\Settings\Diverse\Unit $unitStorage
     * @return InventoryArticles
     */
    public function setUnitStorage(\AppBundle\Entity\Settings\Diverse\Unit $unitStorage = null)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage
     *
     * @return string|\AppBundle\Entity\Settings\Diverse\Unit
     */
    public function getUnitStorage()
    {
        return $this->unitStorage;
    }

    /**
     * Set zoneStorage
     *
     * @param string $zoneStorage
     * @return InventoryArticles
     */
    public function setZoneStorage($zoneStorage = null)
    {
        $this->zoneStorage = $zoneStorage;

        return $this;
    }

    /**
     * Get zoneStorage
     *
     * @return string
     */
    public function getZoneStorage()
    {
        return $this->zoneStorage;
    }
}
