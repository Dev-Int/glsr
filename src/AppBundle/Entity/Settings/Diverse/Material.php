<?php

/**
 * Entité Material.
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
namespace AppBundle\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Settings\Diverse\UnitStorage;
use AppBundle\Entity\Settings\Article;

/**
 * Material
 *
 * @ORM\Table(name="gs_material")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Settings\Diverse\MaterialRepository")
 */
class Material
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", unique=true)
     */
    private $name;

    /**
     * @var string|\AppBundle\Entity\Settings\Diverse\UnitStorage Unité de stockage
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Diverse\UnitStorage")
     */
    private $unitStorage;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="multiple", type="boolean")
     */
    private $multiple;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection Article(s)
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Settings\Article")
     * @ORM\JoinTable(name="gs_material_article")
     * @Assert\NotBlank()
     */
    private $articles;

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
        $this->articles = new ArrayCollection();
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
     * @return Material
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
     * Set active
     *
     * @param boolean $active
     * @return Material
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
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set multiple
     *
     * @param boolean $multiple
     * @return Material
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get multiple
     *
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * Set unitStorage
     *
     * @param \AppBundle\Entity\Settings\Diverse\UnitStorage $unitStorage
     * @return Material
     */
    public function setUnitStorage(UnitStorage $unitStorage = null)
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
     * Add articles
     *
     * @param \AppBundle\Entity\Settings\Article $articles
     * @return Material
     */
    public function addArticle(Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \AppBundle\Entity\Settings\Article $articles
     */
    public function removeArticle(Article $articles)
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

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
