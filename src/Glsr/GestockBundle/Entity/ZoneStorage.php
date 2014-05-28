<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZoneStorage
 *
 * @ORM\Table(name="gs_zonestorage")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\ZoneStorageRepository")
 */
class ZoneStorage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * @return ZoneStorage
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
    
    // Cette méthode permet de faire "echo $zoneStorage"
    // Ainsi, pour "afficher" $zoneStorage, PHP affichera en réalité le retour de cette méthode
    // Ici, le nom, donc "echo $zoneStorage" est équivalent à "echo $zoneStorage->getName()"
    public function __toString()
    {
        return $this->name;
    }
}
