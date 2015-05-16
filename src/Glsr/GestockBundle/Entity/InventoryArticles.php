<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inventory_articles.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_inventory_articles")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\inventoryArticlesRepository")
 */
class InventoryArticles
{
    /**
     * @var int Id de l'article de l'inventaire
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float Stock réel
     *
     * @ORM\Column(name="realstock", type="decimal", scale=3, nullable=true)
     */
    private $realstock;

    /**
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\Inventory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventory;

    /**
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    /**
     * @var float Total article
     *
     * @ORM\Column(name="total", type="decimal", scale=3, nullable=true)
     */
    private $total;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return InventoryArticles
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inventory.
     *
     * @param Inventory $inventory
     *
     * @return InventoryArticles
     */
    public function setInventory(Inventory $inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory.
     *
     * @return \Glsr\GestockBundle\Entity\Invetory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set articles.
     *
     * @param Article $articles
     *
     * @return InventoryArticles
     */
    public function setArticles(Article $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Get articles.
     *
     * @return Article
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set realstock.
     *
     * @param string $realstock
     *
     * @return InventoryArticles
     */
    public function setRealstock($realstock)
    {
        $this->realstock = $realstock;

        return $this;
    }

    /**
     * Get realstock.
     *
     * @return string
     */
    public function getRealstock()
    {
        return $this->realstock;
    }

    /**
     * Set total.
     *
     * @param string $total
     *
     * @return InventoryArticles
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }
}
