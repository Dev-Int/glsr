<?php

/**
 * Entity InventoryArticles.
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
namespace  App\Entity\Stocks;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryArticles entity.
 *
 * @ORM\Table(name="gs_inventory_articles")
 * @ORM\Entity(repositoryClass="App\Repository\Stocks\InventoryArticlesRepository")
 */
class InventoryArticles
{
    /**
     * @var integer $artsId
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $artsId;

    /**
     * @var Inventory $inventory Inventory id
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Stocks\Inventory", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventory;

    /**
     * @var Article $article Article id
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var decimal $quantity Quantity in theoretical stock
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3, nullable=true, options={"default":0})
     */
    private $quantity;

    /**
     * @var decimal $realstock Quantity in real stock
     *
     * @ORM\Column(name="realstock", type="decimal", precision=7, scale=3, options={"default" = 0})
     */
    private $realstock;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit $unitStorage Storage unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitStorage;

    /**
     * @var decimal $price Price of the article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $price;

    /**
     * @var string $zoneStorage Storage area
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
        return $this->artsId;
    }

    /**
     * Set inventory
     *
     * @param \App\Entity\Stocks\Inventory $inventory
     * @return InventoryArticles
     */
    public function setInventory(\App\Entity\Stocks\Inventory $inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return \App\Entity\Stocks\Inventory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set article
     *
     * @param \App\Entity\Settings\Article $article
     * @return InventoryArticles
     */
    public function setArticle(\App\Entity\Settings\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \App\Entity\Settings\Article
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
     * @param null|\App\Entity\Settings\Diverse\Unit $unitStorage
     * @return InventoryArticles
     */
    public function setUnitStorage(\App\Entity\Settings\Diverse\Unit $unitStorage = null)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage
     *
     * @return string|\App\Entity\Settings\Diverse\Unit
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
