<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * Supplier
 *
 * @ORM\Table(name="gs_supplier")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\SupplierRepository")
 */
class Supplier
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="zipcode", type="integer")
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var phone_number
     *
     * @ORM\Column(name="phone", type="phone_number")
     * 
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $phone;

    /**
     * @var phone_number
     *
     * @ORM\Column(name="fax", type="phone_number")
     * 
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=50)
     */
    private $contact;

    /**
     * @var phone_number
     *
     * @ORM\Column(name="gsm", type="phone_number")
     * 
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $gsm;

    /**
     * @var string $family_log Famille logistique
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\FamilyLog")
     */
    private $family_log;

    /**
     * @var string $sub_family_log Sous-famille logistique
     * 
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\SubFamilyLog")
     */
    private $sub_family_log;

    /**
     * @var integer
     *
     * @ORM\Column(name="delaydeliv", type="smallint")
     */
    private $delaydeliv;

    /**
     * @var array $orderdate Tableau des jours de commande
     *
     * @ORM\Column(name="orderdate", type="simple_array")
     */
    private $orderdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    public function __construct()
    {
        $this->active = TRUE;
    }
    
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
     * @return Supplier
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
     * Set address
     *
     * @param string $address
     * @return Supplier
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     * @return Supplier
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return integer 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return Supplier
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Supplier
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Supplier
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Supplier
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Supplier
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set gsm
     *
     * @param string $gsm
     * @return Supplier
     */
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;

        return $this;
    }

    /**
     * Get gsm
     *
     * @return string 
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * Set delaydeliv
     *
     * @param integer $delaydeliv
     * @return Supplier
     */
    public function setDelaydeliv($delaydeliv)
    {
        $this->delaydeliv = $delaydeliv;

        return $this;
    }

    /**
     * Get delaydeliv
     *
     * @return integer 
     */
    public function getDelaydeliv()
    {
        return $this->delaydeliv;
    }

    /**
     * Set orderdate
     *
     * @param array $orderdate
     * @return Supplier
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return array 
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return Supplier
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set family_log
     *
     * @param \Glsr\GestockBundle\Entity\FamilyLog $familyLog
     * @return Supplier
     */
    public function setFamilyLog(\Glsr\GestockBundle\Entity\FamilyLog $familyLog = null)
    {
        $this->family_log = $familyLog;

        return $this;
    }

    /**
     * Get family_log
     *
     * @return \Glsr\GestockBundle\Entity\FamilyLog 
     */
    public function getFamilyLog()
    {
        return $this->family_log;
    }

    /**
     * Set sub_family_log
     *
     * @param \Glsr\GestockBundle\Entity\SubFamilyLog $subFamilyLog
     * @return Supplier
     */
    public function setSubFamilyLog(\Glsr\GestockBundle\Entity\SubFamilyLog $subFamilyLog = null)
    {
        $this->sub_family_log = $subFamilyLog;

        return $this;
    }

    /**
     * Get sub_family_log
     *
     * @return \Glsr\GestockBundle\Entity\SubFamilyLog 
     */
    public function getSubFamilyLog()
    {
        return $this->sub_family_log;
    }
    
    // Cette méthode permet de faire "echo $supplier"
    // Ainsi, pour "afficher" $supplier, PHP affichera en réalité le retour de cette méthode
    // Ici, le nom, donc "echo $supplier" est équivalent à "echo $supplier->getName()"
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Supplier
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}