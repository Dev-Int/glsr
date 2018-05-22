<?php

/**
 * Entity Unit.
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
 * Unit Entité.
 *
 * @category Entity
 *
 * @ORM\Table(name="app_unit")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\UnitRepository")
 */
class Unit
{
    /**
     * @var int Id of unit
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Name of unit
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Abbreviation of the unit
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
     * This method lets you do "echo $unit".
     * <p>So, to "show" $unit,
     * PHP will actually show the return of this method. <br />
     * Here, the name, so "echo $unit"
     * is equivalent to "echo $unit->getName ()"</p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->abbr;
    }
}
