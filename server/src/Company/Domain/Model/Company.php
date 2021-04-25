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

namespace Company\Domain\Model;

use Core\Domain\Common\Model\Contact;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

final class Company extends Contact
{
    public static function create(
        ContactUuid $uuid,
        NameField $companyName,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $cellphone
    ): self {
        return new self(
            $uuid,
            $companyName,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $facsimile,
            $email,
            $contact,
            $cellphone
        );
    }

    public function renameCompany(NameField $companyName): void
    {
        $this->companyName = $companyName->getValue();
        $this->slug = $companyName->slugify();
    }
}
