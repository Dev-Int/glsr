<?php

/**
 * Entity Article.
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
namespace  App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Settings\Supplier;
use App\Entity\Settings\Diverse\Unit;
use App\Entity\Settings\Diverse\ZoneStorage;
use App\Entity\Settings\Diverse\FamilyLog;

/**
 * Article entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_article")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\ArticleRepository")
 * @UniqueEntity(fields="name", message="Ce nom d'article est déjà utilisé.")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @var int $artId Id of the article
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $artId;

    /**
     * @var string $name title of the article
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
     * @var string|\App\Entity\Settings\Supplier $supplier Name of supplier
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Supplier")
     */
    private $supplier;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit $unitStorage Storage unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitStorage;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit $unitWorking Working unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitWorking;

    /**
     * @var double $packaging Conditioning (quantity)
     *
     * @ORM\Column(name="packaging", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $packaging;

    /**
     * @var double $price price of the article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $price;

    /**
     * @var string|\App\Entity\Settings\Diverse\Tva $tva VAT rate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Tva")
     */
    private $tva;

    /**
     * @var double $quantity Quantity in stock
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3, nullable=true, options={"default":0})
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $quantity;

    /**
     * @var double $minstock Minimum stock
     *
     * @ORM\Column(name="minstock", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $minstock;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $zoneStorages Storage area(s)
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Settings\Diverse\ZoneStorage")
     * @ORM\JoinTable(name="gs_article_zonestorage")
     * @Assert\NotBlank()
     */
    private $zoneStorages;

    /**
     * @var string|\App\Entity\Settings\Diverse\FamilyLog $familyLog Logistic family
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\FamilyLog")
     * @Assert\NotBlank()
     */
    private $familyLog;

    /**
     * @var bool On/Off
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string $slug
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
        return $this->artId;
    }

    /**
     * Set name.
     *
     * @param string $name Name of article
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
     * @param double $packaging Conditioning (quantity)
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
     * @param double $price price of the article
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
     * @param double $quantity quantity in stock
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
     * @param double $minstock minimum stock
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
     * @param null|\App\Entity\Settings\Supplier $supplier Supplier of the article
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
     * @return string|\App\Entity\Settings\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set unitStorage.
     *
     * @param null|\App\Entity\Settings\Diverse\Unit $unitStorage Storage unit
     *
     * @return Article
     */
    public function setUnitStorage(Unit $unitStorage = null)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage.
     *
     * @return string|\App\Entity\Settings\Diverse\Unit
     */
    public function getUnitStorage()
    {
        return $this->unitStorage;
    }

    /**
     * Add zoneStorage.
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zoneStorages Storage area(s)
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
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zoneStorages Storage area to delete
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
     * Set unitWorking
     *
     * @param \App\Entity\Settings\Diverse\Unit $unitWorking
     * @return Article
     */
    public function setUnitWorking(Unit $unitWorking = null)
    {
        $this->unitWorking = $unitWorking;

        return $this;
    }

    /**
     * Get unitWorking
     *
     * @return \App\Entity\Settings\Diverse\UnitWorking
     */
    public function getUnitWorking()
    {
        return $this->unitWorking;
    }

    /**
     * Set familyLog.
     *
     * @param null|\App\Entity\Settings\Diverse\FamilyLog $familyLog Logistics Family
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
     * @return \App\Entity\Settings\Diverse\FamilyLog
     */
    public function getFamilyLog()
    {
        return $this->familyLog;
    }

    /**
     * Set tva
     *
     * @param \App\Entity\Settings\Diverse\Tva $tva
     * @return Article
     */
    public function setTva(\App\Entity\Settings\Diverse\Tva $tva = null)
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

    /**
     * Set active.
     *
     * @param bool $active On/Off
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
     * This method allows to do "echo $article".
     * <p> So, to "show" $uniarticlet,
     * PHP will actually show the return of this method. <br />
     * Here, the abbreviation, so "echo $article"
     * is equivalent to "echo $article->getName()" </ p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
    }
}
