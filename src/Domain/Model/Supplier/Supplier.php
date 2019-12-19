<?php

declare(strict_types=1);

namespace Domain\Model\Supplier;

use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;
use Domain\Model\Common\VO\PhoneField;
use Domain\Model\Contact;

class Supplier extends Contact
{
    /**
     * @var int id du fournisseur
     */
    private $id;

    /**
     * @var string Famille logistique
     */
    private $familyLog;

    /**
     * @var int Délai de livraison
     */
    private $delayDeliv;

    /**
     * @var array Tableau des jours de commande
     */
    private $orderDays;

    /**
     * @var bool Activé/Désactivé
     */
    private $active;

    /**
     * @var string
     */
    private $slug;

    /**
     * Supplier constructor.
     * @param NameField $name
     * @param string $address
     * @param string $zipCode
     * @param string $town
     * @param string $country
     * @param PhoneField $phone
     * @param PhoneField $fax
     * @param EmailField $email
     * @param string $contact
     * @param PhoneField $gsm
     * @param string $familyLog
     * @param int $delayDeliv
     * @param array $orderDays
     * @param bool $active
     */
    public function __construct(
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $fax,
        EmailField $email,
        string $contact,
        PhoneField $gsm,
        string $familyLog,
        int $delayDeliv,
        array $orderDays,
        bool $active = true
    ) {
        parent::__construct(
            $name,
            $address,
            $zipCode,
            $town,
            $country,
            $phone->getValue(),
            $fax->getValue(),
            $email,
            $contact,
            $gsm->getValue()
        );
        $this->familyLog = $familyLog;
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
        PhoneField $fax,
        EmailField $email,
        string $contact,
        PhoneField $gsm,
        string $familyLog,
        int $delayDeliv,
        array $orderDays,
        bool $active = true
    ): self {
        return new self(
            $name,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $fax,
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
