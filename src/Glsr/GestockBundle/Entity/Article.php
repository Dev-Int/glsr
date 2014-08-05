<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Article
 *
 * @ORM\Table(name="gs_article")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\ArticleRepository")
 * @UniqueEntity(fields="name", message="Ce nom d'article est déjà utilisé dans le système.")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
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
     * @var string $name intitulé de l'article
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="'^\w+[^/]'", message="L'intitulé ne peut contenir que des lettres, chiffres et _ ou -")
     * 
     */
    private $name;
    
    /**
     * @var string $supplier Nom du fournisseur
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\Supplier") 
     */
    private $supplier;

    /**
     * @var string $unit_storage Unité de stockage
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\UnitStorage")
     * @ORM\JoinTable(name="gs_article_unitstorage")
     */
    private $unit_storage;
    
    /**
     * @var $unit_bill
     *
     * @ORM\Column(name="unit_bill", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $unit_bill;

    /**
     * @var $price
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $price;

    /**
     * @var $quantity
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $quantity;

    /**
     * @var $minstock
     *
     * @ORM\Column(name="minstock", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $minstock;

    /**
     * @var realstock
     *
     * @ORM\Column(name="realstock", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $realstock;
    
    /**
     * @var string $zonestorage Zone(s) de stockage
     * 
     * @ORM\ManyToMany(targetEntity="Glsr\GestockBundle\Entity\ZoneStorage")
     * @ORM\JoinTable(name="gs_article_zonestorage")
     * @Assert\NotBlank()
     */
    private $zone_storages;

    /**
     * @var string $family_log Famille logistique
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\FamilyLog")
     * @Assert\NotBlank()
     */
    private $family_log;

    /**
     * @var string $sub_family_log Sous-famille logistique
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\SubFamilyLog")
     * @Assert\NotBlank()
     */
    private $sub_family_log;

    /**
     * @var boolean $active 
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zone_storages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->active = TRUE;
        $this->quantity = 0.000;
        $this->realstock = 0.000;
        
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
     * Set name
     *
     * @param string $name
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set unit_bill
     *
     * @param string $unitBill
     * @return Article
     */
    public function setUnitBill($unitBill)
    {
        $this->unit_bill = $unitBill;

        return $this;
    }

    /**
     * Get unit_bill
     *
     * @return string 
     */
    public function getUnitBill()
    {
        return $this->unit_bill;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Article
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
     * Set quantity
     *
     * @param string $quantity
     * @return Article
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
     * Set minstock
     *
     * @param string $minstock
     * @return Article
     */
    public function setMinstock($minstock)
    {
        $this->minstock = $minstock;

        return $this;
    }

    /**
     * Get minstock
     *
     * @return string 
     */
    public function getMinstock()
    {
        return $this->minstock;
    }

    /**
     * Set realstock
     *
     * @param string $realstock
     * @return Article
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
     * Set is_active
     *
     * @param boolean $isActive
     * @return Article
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set supplier
     *
     * @param \Glsr\GestockBundle\Entity\Supplier $supplier
     * @return Article
     */
    public function setSupplier(\Glsr\GestockBundle\Entity\Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \Glsr\GestockBundle\Entity\Supplier 
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set unit_storage
     *
     * @param \Glsr\GestockBundle\Entity\UnitStorage $unitStorage
     * @return Article
     */
    public function setUnitStorage(\Glsr\GestockBundle\Entity\UnitStorage $unitStorage = null)
    {
        $this->unit_storage = $unitStorage;

        return $this;
    }

    /**
     * Get unit_storage
     *
     * @return \Glsr\GestockBundle\Entity\UnitStorage 
     */
    public function getUnitStorage()
    {
        return $this->unit_storage;
    }

    /**
     * Add zone_storages
     *
     * @param \Glsr\GestockBundle\Entity\ZoneStorage $zoneStorages
     * @return Article
     */
    public function addZoneStorage(\Glsr\GestockBundle\Entity\ZoneStorage $zoneStorages)
    {
        $this->zone_storages[] = $zoneStorages;

        return $this;
    }

    /**
     * Remove zone_storages
     *
     * @param \Glsr\GestockBundle\Entity\ZoneStorage $zoneStorages
     */
    public function removeZoneStorage(\Glsr\GestockBundle\Entity\ZoneStorage $zoneStorages)
    {
        $this->zone_storages->removeElement($zoneStorages);
    }

    /**
     * Get zone_storages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZoneStorages()
    {
        return $this->zone_storages;
    }

    /**
     * Set family_log
     *
     * @param \Glsr\GestockBundle\Entity\FamilyLog $familyLog
     * @return Article
     */
    public function setFamilyLog(\Glsr\GestockBundle\Entity\FamilyLog $familyLog = null)
    {
        $this->family_log = $familyLog;

        return $this;
    }

    /**
     * Get family_log
     *
     * @return \Glsr\GestockBundle\Entity\FamilyLog 
     */
    public function getFamilyLog()
    {
        return $this->family_log;
    }

    /**
     * Set sub_family_log
     *
     * @param \Glsr\GestockBundle\Entity\SubFamilyLog $subFamilyLog
     * @return Article
     */
    public function setSubFamilyLog(\Glsr\GestockBundle\Entity\SubFamilyLog $subFamilyLog = null)
    {
        $this->sub_family_log = $subFamilyLog;

        return $this;
    }

    /**
     * Get sub_family_log
     *
     * @return \Glsr\GestockBundle\Entity\SubFamilyLog 
     */
    public function getSubFamilyLog()
    {
        return $this->sub_family_log;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Article
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}
