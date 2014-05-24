<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubFamilyLog
 *
 * @ORM\Table(name="gs_subfamilylog")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\SubFamilyLogRepository")
 */
class SubFamilyLog
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
     * @var string $familylog
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\FamilyLog")
     * @ORM\JoinColumn(nullable=false)
     */
    private $familylog;



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
     * @return SubFamilyLog
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
     * Constructor
     */
    public function __construct()
    {
        $this->familylogs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add familylogs
     *
     * @param \Glsr\GestockBundle\Entity\FamilyLog $familylogs
     * @return SubFamilyLog
     */
    public function addFamilylog(\Glsr\GestockBundle\Entity\FamilyLog $familylogs)
    {
        $this->familylogs[] = $familylogs;

        return $this;
    }

    /**
     * Remove familylogs
     *
     * @param \Glsr\GestockBundle\Entity\FamilyLog $familylogs
     */
    public function removeFamilylog(\Glsr\GestockBundle\Entity\FamilyLog $familylogs)
    {
        $this->familylogs->removeElement($familylogs);
    }

    /**
     * Get familylogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFamilylogs()
    {
        return $this->familylogs;
    }

    /**
     * Set familylog
     *
     * @param \Glsr\GestockBundle\Entity\FamilyLog $familylog
     * @return SubFamilyLog
     */
    public function setFamilylog(\Glsr\GestockBundle\Entity\FamilyLog $familylog)
    {
        $this->familylog = $familylog;

        return $this;
    }

    /**
     * Get familylog
     *
     * @return \Glsr\GestockBundle\Entity\FamilyLog 
     */
    public function getFamilylog()
    {
        return $this->familylog;
    }
}
