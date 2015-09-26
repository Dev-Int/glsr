<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;

/**
 * Détail des articles de l'inventaire.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_inventory_articles")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\InventoryArticlesRepository")
 */
class InventoryArticles
{
    /**
     * @var int Id ligne de détail de l'inventaire
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var decimal Stock réel (relevé pendant l'inventaire)
     *
     * @ORM\Column(name="realstock", type="decimal", scale=3, nullable=true)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
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
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
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

    /**
     * Set articles
     *
     * @param \Glsr\GestockBundle\Entity\Article $articles
     * @return InventoryArticles
     */
    public function setArticles(\Glsr\GestockBundle\Entity\Article $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Get articles
     *
     * @return \Glsr\GestockBundle\Entity\Article 
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
