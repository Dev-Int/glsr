<?php

/**
 * Entité Unit.
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
 * Unit Entité.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_unit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Settings\Diverse\UnitRepository")
 */
class Unit
{
    /**
     * @var int Id de l'unité
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Nom de l'unité
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Abbréviation de l'unité
     *
     * @ORM\Column(name="abbr", type="string", length=50)
     */
    private $abbr;
    
    /**
     * @var string Slug name
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
     * @return Unit
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
     * Set abbr
     *
     * @param string $abbr
     * @return Unit
     */
    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;

        return $this;
    }

    /**
     * Get abbr
     *
     * @return string
     */
    public function getAbbr()
    {
        return $this->abbr;
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
     * Cette méthode permet de faire "echo $unit".
     * <p>Ainsi, pour "afficher" $unit,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $unit"
     * est équivalent à "echo $unit->getName()"</p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->abbr;
    }
}
