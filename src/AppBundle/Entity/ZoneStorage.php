<?php

/**
 * Entité ZoneStorage.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ZoneStorage.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_zonestorage")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ZoneStorageRepository")
 */
class ZoneStorage
{
    /**
     * @var int Id De la zone de stockage
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Nom de la zone de stockage
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
     * @param string $name Nom de la zone de stockage
     *
     * @return ZoneStorage
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
     * Cette méthode permet de faire "echo $zoneStorage".
     * <p>Ainsi, pour "afficher" $zoneStorage,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $zoneStorage"
     * est équivalent à "echo $zoneStorage->getName()"</p>.
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
}
