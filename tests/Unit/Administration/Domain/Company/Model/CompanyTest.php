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

namespace Unit\Tests\Administration\Domain\Company\Model;

use Administration\Domain\Company\Model\Company;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    final public function testInstantiateCompany(): void
    {
        // Arrange & Act
        $company = Company::create(
            ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001')
        );

        // Assert
        static::assertEquals(
            new Company(
                ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Davigel'),
                '15, rue des givrés',
                '75000',
                'Paris',
                'France',
                PhoneField::fromString('+33100000001'),
                PhoneField::fromString('+33100000002'),
                EmailField::fromString('contact@davigel.fr'),
                'David',
                PhoneField::fromString('+33600000001')
            ),
            $company
        );
    }

    final public function testRenameCompany(): void
    {
        // Arrange
        $company = Company::create(
            ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001')
        );

        // Act
        $company->renameCompany(NameField::fromString('Trans Gourmet'));

        // Assert
        static::assertEquals(
            new Company(
                ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Trans Gourmet'),
                '15, rue des givrés',
                '75000',
                'Paris',
                'France',
                PhoneField::fromString('+33100000001'),
                PhoneField::fromString('+33100000002'),
                EmailField::fromString('contact@davigel.fr'),
                'David',
                PhoneField::fromString('+33600000001')
            ),
            $company
        );
    }

    final public function testRewriteAddressCompany(): void
    {
        // Arrange
        $company = Company::create(
            ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001')
        );

        // Act
        $company->rewriteAddress([
            '25, rue des givrons',
            '56000',
            'Lorient',
            'France',
        ]);

        // Assert
        static::assertEquals(
            new Company(
                ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Davigel'),
                '25, rue des givrons',
                '56000',
                'Lorient',
                'France',
                PhoneField::fromString('+33100000001'),
                PhoneField::fromString('+33100000002'),
                EmailField::fromString('contact@davigel.fr'),
                'David',
                PhoneField::fromString('+33600000001')
            ),
            $company
        );
    }

    final public function testChangePhoneNumbersCompany(): void
    {
        // Arrange
        $company = Company::create(
            ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001')
        );

        // Act
        $company->changePhoneNumber(PhoneField::fromString('+33100050001'));
        $company->changeFacsimileNumber(PhoneField::fromString('+33100050002'));
        $company->changeCellphoneNumber(PhoneField::fromString('+33600050001'));

        // Assert
        static::assertEquals(
            new Company(
                ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Davigel'),
                '15, rue des givrés',
                '75000',
                'Paris',
                'France',
                PhoneField::fromString('+33100050001'),
                PhoneField::fromString('+33100050002'),
                EmailField::fromString('contact@davigel.fr'),
                'David',
                PhoneField::fromString('+33600050001')
            ),
            $company
        );
    }

    final public function testChangeEmailCompany(): void
    {
        // Arrange
        $company = Company::create(
            ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001')
        );

        // Act
        $company->rewriteEmail(EmailField::fromString('david@davigel.fr'));

        // Assert
        static::assertEquals(
            new Company(
                ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Davigel'),
                '15, rue des givrés',
                '75000',
                'Paris',
                'France',
                PhoneField::fromString('+33100000001'),
                PhoneField::fromString('+33100000002'),
                EmailField::fromString('david@davigel.fr'),
                'David',
                PhoneField::fromString('+33600000001')
            ),
            $company
        );
    }
}
