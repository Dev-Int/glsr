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

use Administration\Domain\User\Model\User;
use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    final public function load(ObjectManager $manager): void
    {
        $userModel = new \Administration\Application\User\ReadModel\User(
            'Laurent',
            'laurent@example.com',
            'password',
            ['ROLE_ADMIN'],
            'a136c6fe-8f6e-45ed-91bc-586374791033'
        );
        $userModel->setPassword(
            $this->passwordEncoder->encodePassword($userModel, $userModel->getPassword())
        );

        $user = new User(
            UserUuid::fromString($userModel->getUuid()),
            NameField::fromString($userModel->getUsername()),
            EmailField::fromString($userModel->getEmail()),
            $userModel->getPassword(),
            $userModel->getRoles()
        );

        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
