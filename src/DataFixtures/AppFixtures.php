<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public static function getGroups(): array
    {
        return ['super_admin'];
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Person(
            username: "Super Admin",
        );

        $admin->email = "super-admin@disquette.fr";
        $admin->setRoles(["ROLE_ADMIN"]);

        $password = $this->userPasswordHasher->hashPassword($admin, "SuperAdmin123!");
        $admin->setPassword($password);

        $manager->persist($admin);
        $manager->flush();
    }
}
