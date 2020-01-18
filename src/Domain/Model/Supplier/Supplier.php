<?php

declare(strict_types=1);

namespace Domain\Model\Supplier;

use Domain\Model\Common\Entities\FamilyLog;
use Domain\Model\Common\VO\ContactAddress;
use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;
use Domain\Model\Common\VO\PhoneField;
use Domain\Model\Contact;

class Supplier extends Contact
{
    /**
     * @var int Id of Supplier
     */
    private $supplierId;

    /**
     * @var string Logistics family
     */
    private $familyLog;

    /**
     * @var int Delivery delay
     */
    private $delayDeliv;

    /**
     * @var array Order days table
     */
    private $orderDays;

    /**
     * @var bool Active/Inactive
     */
    private $active;

    /**
     * @var string
     */
    private $slug;

    /**
     * Supplier constructor.
     *
     * @param NameField      $name
     * @param ContactAddress $address
     * @param PhoneField     $phone
     * @param PhoneField     $facsimile
     * @param EmailField     $email
     * @param string         $contact
     * @param PhoneField     $cellphone
     * @param FamilyLog      $familyLog
     * @param int            $delayDeliv
     * @param array          $orderDays
     * @param bool           $active
     */
    public function __construct(
        NameField $name,
        ContactAddress $address,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $cellphone,
        FamilyLog $familyLog,
        int $delayDeliv,
        array $orderDays,
        bool $active = true
    ) {
        parent::__construct(
            $name,
            $address,
            $phone->getValue(),
            $facsimile->getValue(),
            $email,
            $contact,
            $cellphone->getValue()
        );
        $this->familyLog = $familyLog->path();
        $this->delayDeliv = $delayDeliv;
        $this->orderDays = $orderDays;
        $this->slug = $name->slugify();
        $this->active = $active;
    }

    public static function create(
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $gsm,
        FamilyLog $familyLog,
        int $delayDeliv,
        array $orderDays,
        bool $active = true
    ): self {
        return new self(
            $name,
            ContactAddress::fromString($address, $zipCode, $town, $country),
            $phone,
            $facsimile,
            $email,
            $contact,
            $gsm,
            $familyLog,
            $delayDeliv,
            $orderDays,
            $active
        );
    }

    final public function renameSupplier(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }

    final public function name(): string
    {
        return $this->name;
    }
}
