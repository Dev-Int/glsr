<?php

/**
 * Entity Orders.
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
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Settings\Supplier;
use App\Entity\Orders\OrdersArticles;

/**
 * Orders
 *
 * @ORM\Table(name="gs_orders")
 * @ORM\Entity(repositoryClass="App\Repository\Orders\OrdersRepository")
 */
class Orders
{
    /**
     * @var int $ordId Id of order
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ordId;

    /**
     * @var string|\App\Entity\Settings\Supplier $supplier Supplier name
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Supplier")
     */
    private $supplier;

    /**
     * @var \DateTime $orderdate Order date
     *
     * @ORM\Column(name="order_date", type="datetime")
     */
    private $orderdate;

    /**
     * @var \DateTime $delivdate Delivery date
     *
     * @ORM\Column(name="deliv_date", type="datetime")
     */
    private $delivdate;

    /**
     * @var float $amount Amount of order
     *
     * @ORM\Column(name="amount", type="decimal", precision=7, scale=3, nullable=true)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $amount;

    /**
     * @var float $tva Amount of VAT
     *
     * @ORM\Column(name="tva", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $tva;

    /**
     * @var App\Entity\Orders\OrdersArticle $articles
     * @ORM\OneToMany(targetEntity="App\Entity\Orders\OrdersArticles", mappedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->orderdate = new \DateTime();
        $this->delivdate = new \DateTime();
        $this->amount = 0.000;
        $this->tva = 0.000;
        $this->status = 1;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->ordId;
    }

    /**
     * Set orderdate
     *
     * @param \DateTime $orderdate
     * @return Orders
     */
    public function setOrderdate(\DateTime $orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * Set delivdate
     *
     * @param \DateTime $delivdate
     * @return Orders
     */
    public function setDelivdate(\DateTime $delivdate)
    {
        $this->delivdate = $delivdate;

        return $this;
    }

    /**
     * Get delivdate
     *
     * @return \DateTime
     */
    public function getDelivdate()
    {
        return $this->delivdate;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Orders
     */
    public function setAmount($amount)
    {
        $this->amount = (double)$amount;

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
     * Set tva
     *
     * @param string $tva
     * @return Orders
     */
    public function setTva($tva)
    {
        $this->tva = (double)$tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Orders
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
     * Set supplier
     *
     * @param \App\Entity\Settings\Supplier $supplier
     * @return Orders
     */
    public function setSupplier(Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \App\Entity\Settings\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Add articles
     *
     * @param \App\Entity\Orders\OrdersArticles $articles
     * @return Orders
     */
    public function addArticle(OrdersArticles $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \App\Entity\Orders\OrdersArticles $articles
     */
    public function removeArticle(OrdersArticles $articles)
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
