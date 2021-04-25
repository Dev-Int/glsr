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

use Administration\Domain\Settings\Model\Settings;
use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Administration\Domain\Settings\Model\VO\SettingsUuid;
use Administration\Infrastructure\Persistence\DoctrineOrm\Entities\Settings as SettingsEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SettingsFixtures extends Fixture implements FixtureGroupInterface
{
    final public function load(ObjectManager $manager): void
    {
        $settings = Settings::create(
            SettingsUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            Locale::fromString('FR'),
            Currency::fromString('Euro')
        );

        $settingsEntity = SettingsEntity::fromModel($settings);

        $manager->persist($settingsEntity);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['settings'];
    }
}
