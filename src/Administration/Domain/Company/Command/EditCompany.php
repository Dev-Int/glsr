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

namespace Administration\Domain\Company\Command;

use Core\Domain\Common\Model\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

final class EditCompany extends AbstractCompanyCommand
{
    private string $uuid;

    public function __construct(
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
        PhoneField $cellPhone
    ) {
        $this->uuid = $uuid->toString();
        parent::__construct(
            $name,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $facsimile,
            $email,
            $contact,
            $cellPhone
        );
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
