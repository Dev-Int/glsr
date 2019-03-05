<?php

/**
 * Entity Unit.
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
namespace  App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Unit Entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_unit")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\UnitRepository")
 */
class Unit
{
    /**
     * @var int $unitId Unit Id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $unitId;

    /**
     * @var string $name Name of the unit
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $abbr Abbreviation of the unit
     *
     * @ORM\Column(name="abbr", type="string", length=50)
     */
    private $abbr;
    
    /**
     * @var string $slug Slug name
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
        return $this->unitId;
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
     * This method allows to do "echo $unit".
     * <p> So, to "show" $unit,
     * PHP will actually show the return of this method. <br />
     * Here, the abbreviation, so "echo $unit"
     * is equivalent to "echo $unit->getAbbr()" </ p>.
     * @return string abbr
     */
    public function __toString()
    {
        return $this->abbr;
    }
}
