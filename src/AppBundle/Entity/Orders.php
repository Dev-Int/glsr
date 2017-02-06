<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Supplier;
use AppBundle\Entity\OrdersArticles;

/**
 * Orders
 *
 * @ORM\Table(name="gs_orders")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OrdersRepository")
 */
class Orders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|\AppBundle\Entity\Supplier Nom du fournisseur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Supplier")
     */
    private $supplier;

    /**
     * @var \DateTime Date de commande
     *
     * @ORM\Column(name="order_date", type="datetime")
     */
    private $orderdate;

    /**
     * @var \DateTime Date de livraison
     *
     * @ORM\Column(name="deliv_date", type="datetime")
     */
    private $delivdate;

    /**
     * @var float Montant de la commande
     *
     * @ORM\Column(name="amount", type="decimal", precision=7, scale=3, nullable=true)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $amount;

    /**
     * @var float Montant de la tva
     *
     * @ORM\Column(name="tva", type="decimal", precision=7, scale=3, nullable=true)
     */
    private $tva;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdersArticles", mappedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    /**
     * @var integer
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
        return $this->id;
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
     * @param \AppBundle\Entity\Supplier $supplier
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
     * @return \AppBundle\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Add articles
     *
     * @param \AppBundle\Entity\OrdersArticles $articles
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
     * @param \AppBundle\Entity\OrdersArticles $articles
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
