<?php

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
    protected $fax;

    /**
     * @var string email de l'entreprise
     */
    protected $mail;

    /**
     * @var string Contact de l'entreprise
     */
    protected $contact;

    /**
     * @var string Gsm de l'entreprise
     */
    protected $gsm;

    /**
     * Contact constructor.
     * @param NameField $name
     * @param string $address
     * @param string $zipCode
     * @param string $town
     * @param string $country
     * @param string $phone
     * @param string $fax
     * @param EmailField $mail
     * @param string $contact
     * @param string $gsm
     */
    public function __construct(
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        string $phone,
        string $fax,
        EmailField $mail,
        string $contact,
        string $gsm
    ) {
        $this->name = $name->getValue();
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->mail = $mail->getValue();
        $this->contact = $contact;
        $this->gsm = $gsm;
    }
}
