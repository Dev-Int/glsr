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

namespace Administration\Infrastructure\Persistence\DoctrineOrm\Entities;

use Administration\Domain\Company\Model\Company as CompanyModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineCompanyRepository")
 */
class Company
{
    /** @ORM\Embedded(class="Contact") */
    private Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public static function fromModel(CompanyModel $companyModel): self
    {
        $contact = new Contact(
            $companyModel->uuid(),
            $companyModel->name(),
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
}
