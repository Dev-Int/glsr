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

namespace Administration\Domain\Company\Model;

use Core\Domain\Common\Model\Contact;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

class Company extends Contact
{
    public static function create(
        ContactUuid $uuid,
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $gsm
    ): self {
        return new self(
            $uuid,
            $name,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $facsimile,
            $email,
            $contact,
            $gsm
        );
    }

    final public function renameCompany(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }
}
