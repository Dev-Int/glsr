<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * tva
 *
 * @ORM\Table(name="gs_tva")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\TvaRepository")
 */
class Tva
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
     * @var decimal,
     *
     * @ORM\Column(name="name", type="decimal", precision=5, scale=3)
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
     * @param decimal $name
     * @return tva
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return decimal, 
     */
    public function getName()
    {
        return $this->name;
    }

}
