<?php

/**
 * Entity Material.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace  App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Settings\Article;

/**
 * Material entity.
 *
 * @ORM\Table(name="gs_material")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\MaterialRepository")
 */
class Material
{
    /**
     * @var int $mtId Id of the material
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $mtId;

    /**
     * @var string $name Name of the material
     *
     * @ORM\Column(name="name", length=128, type="string", unique=true)
     */
    private $name;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit $unitWorking Storage unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitWorking;

    /**
     * @var bool $active
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var bool $multiple
     *
     * @ORM\Column(name="multiple", type="boolean")
     */
    private $multiple;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $articles Article(s)
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Settings\Article")
     * @ORM\JoinTable(name="gs_material_article")
     * @Assert\NotBlank()
     */
    private $articles;

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
        $this->articles = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->mtId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Material
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
     * Set active.
     *
     * @param bool $active
     *
     * @return Material
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set multiple.
     *
     * @param bool $multiple
     *
     * @return Material
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get multiple.
     *
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * Set unitStorage.
     *
     * @param \App\Entity\Settings\Diverse\Unit $unitWorking
     *
     * @return Material
     */
    public function setUnitWorking(Unit $unitWorking = null)
    {
        $this->unitWorking = $unitWorking;

        return $this;
    }

    /**
     * Get unitWorking.
     *
     * @return \App\Entity\Settings\Diverse\Units
     */
    public function getUnitWorking()
    {
        return $this->unitWorking;
    }

    /**
     * Add articles.
     *
     * @param \App\Entity\Settings\Article $articles
     *
     * @return Material
     */
    public function addArticle(Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles.
     *
     * @param \App\Entity\Settings\Article $articles
     */
    public function removeArticle(Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
