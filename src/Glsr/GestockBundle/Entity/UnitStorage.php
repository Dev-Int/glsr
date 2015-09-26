<?php

/**
 * UnitStorage Entité UnitStorage.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: 76be3685d475a2e2d7289ef39832d65414e9ba6d
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnitStorage Entité UnitStorage.
 *
 * PHP Version 5
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_unitstorage")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\UnitStorageRepository")
 */
class UnitStorage
{
    /**
     * @var int Id de l'unité de stockage
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idUStor;

    /**
     * @var string Nom de l'unité de stockage
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Abbréviation de l'unité de stockage
     *
     * @ORM\Column(name="abbr", type="string", length=50)
     */
    private $abbr;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->idUStor;
    }

    /**
     * Set name.
     *
     * @param string $name Nom de l'unité de stockage
     *
     * @return UnitStorage
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
     * Set abbr.
     *
     * @param string $abbr Abbréviation de l'unité de stockage
     *
     * @return UnitStorage
     */
    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;

        return $this;
    }

    /**
     * Get abbr.
     *
     * @return string
     */
    public function getAbbr()
    {
        return $this->abbr;
    }

    /**
     * Cette méthode permet de faire "echo $unitStorage".
     * <p>Ainsi, pour "afficher" $unitStorage,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $unitStorage"
     * est équivalent à "echo $unitStorage->getName()"</p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->abbr;
    }
}
