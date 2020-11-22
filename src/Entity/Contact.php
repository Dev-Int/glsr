<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class Contact
{
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
     * @var string Téléphone de l'entreprise
     *
     * @ORM\Column(name="phone", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $phone;

    /**
     * @var string Fax de l'entreprise
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
    private $email;

    /**
     * @var string Contact de l'entreprise
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var string Gsm de l'entreprise
     *
     * @ORM\Column(name="gsm", type="phone_number")
     * @Assert\NotBlank()
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    private $gsm;

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function setTown(string $town): self
    {
        $this->town = strtoupper($town);

        return $this;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getFax(): string
    {
        return $this->fax;
    }

    public function setEmail(string $email):self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function setGsm(string $gsm): self
    {
        $this->gsm = $gsm;

        return $this;
    }

    public function getGsm(): string
    {
        return $this->gsm;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCompleteAddress(): string
    {
        return $this->address . '<br>' . $this->zipcode . ' ' . $this->town;
    }
}
