<?php

/**
 * Entity ZoneStorage.
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
 * ZoneStorage entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_zonestorage")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\ZoneStorageRepository")
 */
class ZoneStorage
{
    /**
     * @var int $zsId Id of the storage area
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $zsId;

    /**
     * @var string $name Name of the storage area
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string $slug Slug name
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->zsId;
    }

    /**
     * Set name.
     *
     * @param string $name Name of the storage area
     *
     * @return Settings\Diverse\ZoneStorage
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
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * This method allows to do "echo $zoneStorage".
     * <p> So, to "show" $unizoneStoraget,
     * PHP will actually show the return of this method. <br />
     * Here, the abbreviation, so "echo $zoneStorage"
     * is equivalent to "echo $zoneStorage->getName()" </ p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
    }
}
