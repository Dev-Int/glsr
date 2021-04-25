<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Company\Infrastructure\Doctrine\Entity;

use Administration\Infrastructure\Persistence\DoctrineOrm\Entities\Contact;
use Company\Domain\Model\Company as CompanyModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="Company\Infrastructure\Doctrine\Repository\CompanyRepository")
 */
class Company extends Contact
{
    public function __construct(Contact $contact)
    {
        parent::__construct(
            $contact->uuid,
            $contact->companyName,
            $contact->address,
            $contact->zipCode,
            $contact->town,
            $contact->country,
            $contact->phone,
            $contact->facsimile,
            $contact->email,
            $contact->contactName,
            $contact->cellphone,
            $contact->slug
        );
    }

    public static function fromModel(CompanyModel $companyModel): self
    {
        $contact = Contact::create(
            $companyModel->uuid(),
            $companyModel->companyName(),
            $companyModel->address(),
            $companyModel->zipCode(),
            $companyModel->town(),
            $companyModel->country(),
            $companyModel->phone(),
            $companyModel->facsimile(),
            $companyModel->email(),
            $companyModel->contactName(),
            $companyModel->cellphone(),
            $companyModel->slug()
        );

        return new self($contact);
    }

    public function update(CompanyModel $companyModel): self
    {
        $this->companyName = $companyModel->companyName();
        $this->address = $companyModel->address();
        $this->zipCode = $companyModel->zipCode();
        $this->town = $companyModel->town();
        $this->country = $companyModel->country();
        $this->phone = $companyModel->phone();
        $this->facsimile = $companyModel->facsimile();
        $this->email = $companyModel->email();
        $this->contactName = $companyModel->contactName();
        $this->cellphone = $companyModel->cellphone();

        return $this;
    }
}
