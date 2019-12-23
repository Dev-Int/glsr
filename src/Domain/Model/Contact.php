<?php

declare(strict_types=1);

namespace Domain\Model;

use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;

class Contact
{
    /**
     * @var string name nom de l'entreprise
     */
    protected $name;

    /**
     * @var string Adresse de l'entreprise
     */
    protected $address;

    /**
     * @var string Code postal
     */
    protected $zipCode;

    /**
     * @var string Ville
     */
    protected $town;

    /**
     * @var string Pays de l'entreprise
     */
    private $country;

    /**
     * @var string Téléphone de l'entreprise
     */
    protected $phone;

    /**
     * @var string Fax de l'entreprise
     */
    protected $facsimile;

    /**
     * @var string email de l'entreprise
     */
    protected $email;

    /**
     * @var string Contact de l'entreprise
     */
    protected $contact;

    /**
     * @var string Gsm de l'entreprise
     */
    protected $cellphone;

    /**
     * Contact constructor.
     *
     * @param NameField  $name
     * @param string     $address
     * @param string     $zipCode
     * @param string     $town
     * @param string     $country
     * @param string     $phone
     * @param string     $facsimile
     * @param EmailField $email
     * @param string     $contact
     * @param string     $cellphone
     */
    public function __construct(
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        string $phone,
        string $facsimile,
        EmailField $email,
        string $contact,
        string $cellphone
    ) {
        $this->name = $name->getValue();
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email->getValue();
        $this->contact = $contact;
        $this->cellphone = $cellphone;
    }
}
