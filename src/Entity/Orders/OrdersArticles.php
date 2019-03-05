<?php

/**
 * Entity OrdersArticles.
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
namespace App\Entity\Orders;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Orders\Orders;

/**
 * OrdersArticles entity.
 *
 * @ORM\Table(name="gs_orders_articles")
 * @ORM\Entity(repositoryClass="App\Repository\Orders\OrdersArticlesRepository")
 */
class OrdersArticles
{
    /**
     * @var integer $artId
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $artId;

    /**
     * @var Orders $orders
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders\Orders", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orders;

    /**
     * @var Article $articles
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var string $quantity Quantity for the order
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3)
     */
    private $quantity;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit $unitStorage Storage unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitStorage;

    /**
     * @var string $price Price of article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $price;

    /**
     * @var string|\App\Entity\Settings\Diverse\Tva $tva Rate of VAT
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Tva")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tva;


    public function __construct()
    {
        $this->quantity = 0.000;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->artId;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return OrdersArticles
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
     * Set price
     *
     * @param string $price
     * @return OrdersArticles
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set orders
     *
     * @param \App\Entity\Orders\Orders $orders
     * @return OrdersArticles
     */
    public function setOrders(Orders $orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return \App\Entity\Orders\Orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set article
     *
     * @param \App\Entity\Settings\Article $article
     * @return OrdersArticles
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
     * Set unitStorage
     *
     * @param \App\Entity\Settings\Diverse\Unit $unitStorage
     * @return OrdersArticles
     */
    public function setUnitStorage(\App\Entity\Settings\Diverse\Unit $unitStorage)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage
     *
     * @return \App\Entity\Settings\Diverse\Unit
     */
    public function getUnitStorage()
    {
        return $this->unitStorage;
    }

    /**
     * Set tva
     *
     * @param \App\Entity\Settings\Diverse\Tva $tva
     * @return OrdersArticles
     */
    public function setTva(\App\Entity\Settings\Diverse\Tva $tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return \App\Entity\Settings\Diverse\Tva
     */
    public function getTva()
    {
        return $this->tva;
    }
}
