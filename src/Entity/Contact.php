<?php

/**
 * SuperClass Entity Contact.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace  App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact Entity.
 *
 * @category Entity
 *
 * @ORM\MappedSuperclass
 */
class Contact
{
    /**
     * @var string Company Name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Company address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string Zip code
     *
     * @ORM\Column(name="zipcode", type="string", length=5)
     */
    private $zipcode;

    /**
     * @var string Town
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var phone_number Company phone
     *
     * @ORM\Column(name="phone", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $phone;

    /**
     * @var phone_number Company Fax
     *
     * @ORM\Column(name="fax", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $fax;

    /**
     * @var string Company email
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
     * @var string Company contact
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var phone_number GSM of the company
     *
     * @ORM\Column(name="gsm", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $gsm;

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Contact
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode.
     *
     * @param string $zipcode
     *
     * @return Contact
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode.
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set town.
     *
     * @param string $town
     *
     * @return Contact
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town.
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set phone.
     *
     * @param phone_number $phone
     *
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return phone_number
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax.
     *
     * @param phone_number $fax
     *
     * @return Contact
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax.
     *
     * @return phone_number
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set mail.
     *
     * @param string $mail
     *
     * @return Contact
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set contact.
     *
     * @param string $contact
     *
     * @return Contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set gsm.
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
     * Get gsm.
     *
     * @return phone_number
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * Set name.
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}