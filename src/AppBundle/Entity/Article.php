<?php

/**
 * Entité Article.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Supplier;
use AppBundle\Entity\UnitStorage;
use AppBundle\Entity\ZoneStorage;
use AppBundle\Entity\FamilyLog;

/**
 * Article.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_article")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArticleRepository")
 * @UniqueEntity(fields="name", message="Ce nom d'article est déjà utilisé.")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @var int Id de l'article
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string intitulé de l'article
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="'^\w+[^/]'",
     *     message="L'intitulé ne peut contenir que des lettres,
     *     chiffres et _ ou -"
     * )
     */
    private $name;

    /**
     * @var string|\AppBundle\Entity\Supplier Nom du fournisseur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Supplier")
     */
    private $supplier;

    /**
     * @var string|\AppBundle\Entity\UnitStorage Unité de stockage
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnitStorage")
     */
    private $unitStorage;

    /**
     * @var double Conditionement (quantité)
     *
     * @ORM\Column(name="packaging", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $packaging;

    /**
     * @var double prix de l'article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $price;

    /**
     * @var string|\AppBundle\Entity\Tva Taux de TVA
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tva")
     */
    private $tva;

    /**
     * @var double Quantité en stock
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $quantity;

    /**
     * @var double Stock minimum
     *
     * @ORM\Column(name="minstock", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $minstock;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection Zone(s) de stockage
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ZoneStorage")
     * @ORM\JoinTable(name="gs_article_zonestorage")
     * @Assert\NotBlank()
     */
    private $zoneStorages;

    /**
     * @var string|\AppBundle\Entity\FamilyLog Famille logistique
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FamilyLog")
     * @Assert\NotBlank()
     */
    private $familyLog;

    /**
     * @var bool Activé/Désactivé
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->zoneStorages = new ArrayCollection();
        $this->active = true;
        $this->quantity = 0.000;
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
     * Set name.
     *
     * @param string $name Nom de l'article
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set packaging.
     *
     * @param double $packaging Conditionnement (quantité)
     *
     * @return Article
     */
    public function setPackaging($packaging)
    {
        $this->packaging = $packaging;

        return $this;
    }

    /**
     * Get packaging.
     *
     * @return double
     */
    public function getPackaging()
    {
        return $this->packaging;
    }

    /**
     * Set price.
     *
     * @param double $price prix de l'article
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity.
     *
     * @param double $quantity quantité en stock
     *
     * @return Article
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return double
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set minstock.
     *
     * @param double $minstock stock minimum
     *
     * @return Article
     */
    public function setMinstock($minstock)
    {
        $this->minstock = $minstock;

        return $this;
    }

    /**
     * Get minstock.
     *
     * @return double
     */
    public function getMinstock()
    {
        return $this->minstock;
    }

    /**
     * Set supplier.
     *
     * @param null|\AppBundle\Entity\Supplier $supplier Fournisseur de l'article
     *
     * @return Article
     */
    public function setSupplier(Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier.
     *
     * @return string|\AppBundle\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set unitStorage.
     *
     * @param null|\AppBundle\Entity\UnitStorage $unitStorage Unité de stockage
     *
     * @return Article
     */
    public function setUnitStorage(UnitStorage $unitStorage = null)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage.
     *
     * @return string|\AppBundle\Entity\UnitStorage
     */
    public function getUnitStorage()
    {
        return $this->unitStorage;
    }

    /**
     * Add zoneStorage.
     *
     * @param \AppBundle\Entity\ZoneStorage
     * $zoneStorages Zone(s) de stockage
     *
     * @return Article
     */
    public function addZoneStorage(ZoneStorage $zoneStorages)
    {
        $this->zoneStorages[] = $zoneStorages;

        return $this;
    }

    /**
     * Remove zoneStorage.
     *
     * @param ZoneStorage $zoneStorages Zone de stockage à supprimer
     *
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function removeZoneStorage(ZoneStorage $zoneStorages)
    {
        $this->zoneStorages->removeElement($zoneStorages);
    }

    /**
     * Get zoneStorage.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getZoneStorages()
    {
        return $this->zoneStorages;
    }

    /**
     * Set familyLog.
     *
     * @param null|\AppBundle\Entity\FamilyLog $familyLog Famille Logistique
     *
     * @return Article
     */
    public function setFamilyLog(FamilyLog $familyLog = null)
    {
        $this->familyLog = $familyLog;

        return $this;
    }

    /**
     * Get familyLog.
     *
     * @return \AppBundle\Entity\FamilyLog
     */
    public function getFamilyLog()
    {
        return $this->familyLog;
    }

    /**
     * Set active.
     *
     * @param bool $active Activé/Désactivé
     *
     * @return Article
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Cette méthode permet de faire "echo $article".
     * <p>Ainsi, pour "afficher" $article,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $article"
     * est équivalent à "echo $article->getName()".</p>
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set tva
     *
     * @param \AppBundle\Entity\Tva $tva
     * @return Article
     */
    public function setTva(\AppBundle\Entity\Tva $tva = null)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return \AppBundle\Entity\Tva
     */
    public function getTva()
    {
        return $this->tva;
    }
}
