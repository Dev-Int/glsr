<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FamilyLog
 *
 * @ORM\Table(name="gs_familylog")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\FamilyLogRepository")
 */
class FamilyLog
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
     * @return FamilyLog
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
    
    // Cette méthode permet de faire "echo $familyLog"
    // Ainsi, pour "afficher" $familyLog, PHP affichera en réalité le retour de cette méthode
    // Ici, le nom, donc "echo $familyLog" est équivalent à "echo $familyLog->getName()"
    public function __toString()
    {
        return $this->name;
    }
}
