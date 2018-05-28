<?php

/**
 * Entity FamilyLog.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FamilyLog Entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="app_familylog")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\MaterializedPathRepository")
 * @Gedmo\Tree(type="materializedPath")
 */
class FamilyLog
{
    /**
     * @var int Logistic family id
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
     * @var string Logistic family name
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\FamilyLog", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Settings\Diverse\FamilyLog", mappedBy="parent")
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
     * @param string $name Designation
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
     * This method allows to do "echo $familyLog".
     * <p> So, to "show" $familyLog,
     * PHP will actually show the return of this method.<br />
     * Here, the name, so "echo $ familyLog"
     * is equivalent to "echo $familyLog->getName ()"</p>.
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
     * @param null|\App\Entity\Settings\Diverse\FamilyLog $parent
     * @return FamilyLog
     */
    public function setParent(\App\Entity\Settings\Diverse\FamilyLog $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \App\Entity\Settings\Diverse\FamilyLog|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \App\Entity\Settings\Diverse\FamilyLog $children
     * @return FamilyLog
     */
    public function addChild(\App\Entity\Settings\Diverse\FamilyLog $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \App\Entity\Settings\Diverse\FamilyLog $children
     */
    public function removeChild(\App\Entity\Settings\Diverse\FamilyLog $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \App\Entity\Settings\Diverse\FamilyLog[]|\Doctrine\Common\Collections\ArrayCollection
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
     * @return \App\Entity\Settings\Diverse\FamilyLog
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
     * @return \App\Entity\Settings\Diverse\FamilyLog
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
            if ($this->level == 2) {
                $return = '|-- ' . $this->name;
            } elseif ($this->level == 3) {
                $return = '|---- ' . $this->name;
            }
        } else {
            $return = '- ' . $this->name;
        }

        return $return;
    }
}
