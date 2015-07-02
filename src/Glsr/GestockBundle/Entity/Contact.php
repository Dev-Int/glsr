<?php

/**
 * Contact SuperClass Entité Contact.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: 3556e219c7c401ae295206e44e1ddee3f6314848
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact Entité Contact.
 *
 * @category   Entity
 *
 * @ORM\MappedSuperclass
 */
class Contact
{
    /**
     * @var int id du contact
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCont;

    /**
     * @var string name nom de l'entreprise
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string Addresse de l'entreprise
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string Code postal
     *
     * @ORM\Column(name="zipcode", type="string", length=5)
     */
    private $zipcode;

    /**
     * @var string Ville
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var phone_number Téléphone de l'entreprise
     *
     * @ORM\Column(name="phone", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $phone;

    /**
     * @var phone_number Fax de l'entreprise
     *
     * @ORM\Column(name="fax", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $fax;

    /**
     * @var string email de l'entreprise
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    private $mail;

    /**
     * @var string Contact de l'entreprise
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var phone_number Gsm de l'entreprise
     *
     * @ORM\Column(name="gsm", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $gsm;

    /**
     * Set address
     *
     * @param string $address
     * @return Contact
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
     * @param string $zipcode
     * @return Contact
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return Contact
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
     * @param phone_number $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return phone_number
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param phone_number $fax
     * @return Contact
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return phone_number
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Contact
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Contact
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
     * @param phone_number $gsm
     *
     * @return Contact
     */
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;

        return $this;
    }

    /**
     * Get gsm
     *
     * @return phone_number
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * Get idCont
     *
     * @return integer
     */
    public function getId()
    {
        return $this->idCont;
    }

    /**
     * Get idCont
     *
     * @return integer
     */
    public function getIdCont()
    {
        return $this->idCont;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contact
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
}
