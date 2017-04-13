<?php

/**
 * Entité OrdersArticles.
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
namespace AppBundle\Entity\Orders;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Orders\Orders;

/**
 * OrdersArticles
 *
 * @ORM\Table(name="gs_orders_articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Orders\OrdersArticlesRepository")
 */
class OrdersArticles
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Orders\Orders", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @var string Quantité de la commande
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3)
     */
    private $quantity;

    /**
     * @var string|\AppBundle\Entity\Settings\Diverse\UnitStorage Unité de stockage
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Diverse\UnitStorage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitStorage;

    /**
     * @var string Prix de l'article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $price;

    /**
     * @var string|\AppBundle\Entity\Settings\Diverse\Tva TVA
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Diverse\Tva")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tva;


    public function __construct()
    {
        $this->quantity = '0,000';
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
     * @param \AppBundle\Entity\Orders\Orders $orders
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
     * @return \AppBundle\Entity\Orders\Orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Settings\Article $article
     * @return OrdersArticles
     */
    public function setArticle(\AppBundle\Entity\Article $article)
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
     * Set unitStorage
     *
     * @param \AppBundle\Entity\Settings\Diverse\UnitStorage $unitStorage
     * @return OrdersArticles
     */
    public function setUnitStorage(\AppBundle\Entity\Settings\Diverse\UnitStorage $unitStorage)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage
     *
     * @return \AppBundle\Entity\Settings\Diverse\UnitStorage
     */
    public function getUnitStorage()
    {
        return $this->unitStorage;
    }

    /**
     * Set tva
     *
     * @param \AppBundle\Entity\Settings\Diverse\Tva $tva
     * @return OrdersArticles
     */
    public function setTva(\AppBundle\Entity\Settings\Diverse\Tva $tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return \AppBundle\Entity\Settings\Diverse\Tva
     */
    public function getTva()
    {
        return $this->tva;
    }
}
