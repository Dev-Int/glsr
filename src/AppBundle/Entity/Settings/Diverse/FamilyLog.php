<?php

/**
 * Entité FamilyLog.
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
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FamilyLog Entité FamilyLog.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_familylog")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\MaterializedPathRepository")
 * @Gedmo\Tree(type="materializedPath")
 */
class FamilyLog
{
    /**
     * @var int Id de la famille logistique
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\TreePath
     * @ORM\Column(length=3000, nullable=true)
     */
    private $path;

    /**
     * @Gedmo\TreePathSource
     * @var string Nom de la famille logistique
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Slug name
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings\Diverse\FamilyLog", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Settings\Diverse\FamilyLog", mappedBy="parent")
     */
    private $children;


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
     * @param string $name Désignation
     *
     * @return FamilyLog
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
     * Cette méthode permet de faire "echo $familyLog".
     * <p>Ainsi, pour "afficher" $familyLog,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $familyLog"
     * est équivalent à "echo $familyLog->getName()"</p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
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
     * Set parent
     *
     * @param null|\AppBundle\Entity\Settings\Diverse\FamilyLog $parent
     * @return FamilyLog
     */
    public function setParent(\AppBundle\Entity\Settings\Diverse\FamilyLog $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Settings\Diverse\FamilyLog|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \AppBundle\Entity\Settings\Diverse\FamilyLog $children
     * @return FamilyLog
     */
    public function addChild(\AppBundle\Entity\Settings\Diverse\FamilyLog $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \AppBundle\Entity\Settings\Diverse\FamilyLog $children
     */
    public function removeChild(\AppBundle\Entity\Settings\Diverse\FamilyLog $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \AppBundle\Entity\Settings\Diverse\FamilyLog[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set path
     *
     * @param string $path
     * @return \AppBundle\Entity\Settings\Diverse\FamilyLog
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return \AppBundle\Entity\Settings\Diverse\FamilyLog
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Allows hierachy display.
     *
     * @return string
     */
    public function getIndentedName()
    {
        $return = '';
        if ($this->parent !== null) {
            for ($i=2; $i <= $this->level; $i++) {
                $return .= '|- -';
            }
            $return .= $this->name;
        } else {
            $return = '|- '.$this->name;
        }

        return $return;
    }
}
