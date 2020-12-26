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

namespace Administration\Infrastructure\DataFixtures;

use Administration\Domain\Company\Model\Company;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements FixtureGroupInterface
{
    final public function load(ObjectManager $manager): void
    {
        $company = Company::create(
            ContactUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Dev-Int Création'),
            '1 rue des ERP',
            '75000',
            'PARIS',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@developpement-interessant.com'),
            'Laurent',
            PhoneField::fromString('+33100000002')
        );
        $manager->persist($company);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['company'];
    }
}
