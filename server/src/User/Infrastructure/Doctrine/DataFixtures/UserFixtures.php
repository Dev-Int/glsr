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

namespace User\Infrastructure\Doctrine\DataFixtures;

use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\ResourceUuid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use User\Domain\Model\User;
use User\Domain\Model\VO\Password;
use User\Infrastructure\Doctrine\Entity\User as UserEntity;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            Password::fromString('Password-1'),
            ['ROLE_ADMIN'],
        );
        $userSymfony = UserEntity::fromModel($user);
        $passwordEncoded = $this->passwordEncoder->encodePassword(
            $userSymfony,
            $user->password()->value()
        );
        $user->changePassword(Password::fromString($passwordEncoded));
        $userEntity = UserEntity::fromModel($user);

        $manager->persist($userEntity);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
