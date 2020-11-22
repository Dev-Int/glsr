<?php

namespace App\DataFixtures;

use App\Entity\Staff\User2;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new User2())
            ->setUsername('Admin')
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive(true)
        ;
        $manager->persist($user);

        $manager->flush();
    }
}
