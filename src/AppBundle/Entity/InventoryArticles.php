<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryArticles
 *
 * @ORM\Table(name="gs_inventory_articles")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\InventoryArticlesRepository")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Inventory", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventory;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article")
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
     * @var string Unité de stockage
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnitStorage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit_storage;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $price;


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
     * @param \AppBundle\Entity\Inventory $inventory
     * @return InventoryArticles
     */
    public function setInventory(\AppBundle\Entity\Inventory $inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return string
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     * @return InventoryArticles
     */
    public function setArticle(\AppBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
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
     * @param string $quantity
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
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unit_storage
     *
     * @param \AppBundle\Entity\UnitStorage $unitStorage
     * @return InventoryArticles
     */
    public function setUnitStorage(\AppBundle\Entity\UnitStorage $unitStorage = null)
    {
        $this->unit_storage = $unitStorage;

        return $this;
    }

    /**
     * Get unit_storage
     *
     * @return \AppBundle\Entity\UnitStorage
     */
    public function getUnitStorage()
    {
        return $this->unit_storage;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set zone_storage
     *
     * @param integer $zoneStorage
     * @return InventoryArticles
     */
    public function setZoneStorage($zoneStorage)
    {
        $this->zone_storage = $zoneStorage;

        return $this;
    }

    /**
     * Get zone_storage
     *
     * @return integer
     */
    public function getZoneStorage()
    {
        return $this->zone_storage;
    }
}
