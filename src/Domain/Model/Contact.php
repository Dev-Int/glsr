<?php

declare(strict_types=1);

namespace Domain\Model;

use Domain\Model\Common\VO\ContactAddress;
use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;

class Contact
{
    /**
     * @var string name Company Name
     */
    protected $name;

    /**
     * @var string Company address
     */
    protected $address;

    /**
     * @var string Company phone number
     */
    protected $phone;

    /**
     * @var string Company fax number
     */
    protected $facsimile;

    /**
     * @var string Company email
     */
    protected $email;

    /**
     * @var string Company contact
     */
    protected $contact;

    /**
     * @var string Company cellphone
     */
    protected $cellphone;

    /**
     * Contact constructor.
     *
     * @param NameField      $name
     * @param ContactAddress $address
     * @param string         $phone
     * @param string         $facsimile
     * @param EmailField     $email
     * @param string         $contact
     * @param string         $cellphone
     */
    public function __construct(
        NameField $name,
        ContactAddress $address,
        string $phone,
        string $facsimile,
        EmailField $email,
        string $contact,
        string $cellphone
    ) {
        $this->name = $name->getValue();
        $this->address = $address->getValue();
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email->getValue();
        $this->contact = $contact;
        $this->cellphone = $cellphone;
    }
}
