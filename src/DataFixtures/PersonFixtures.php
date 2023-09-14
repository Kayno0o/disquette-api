<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PersonFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public static function getGroups(): array
    {
        return ['super_admin'];
    }

    private array $datas = [
        [
            'username' => 'Super Admin',
            'roles' => [Person::ROLE_SUPER_ADMIN],
            'email' => 'super.admin@kayn.ooo',
        ],
        [
            'username' => 'Admin',
            'roles' => [Person::ROLE_ADMIN],
            'email' => 'admin@kayn.ooo',
        ],
        [
            'username' => 'User',
            'roles' => [Person::DEFAULT_ROLE],
            'email' => 'user@kayn.ooo',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->datas as $data) {
            $user = new Person(
                username: $data['username'],
                email: $data['email'],
                roles: $data['roles'],
            );
            $password = $this->userPasswordHasher->hashPassword($user, "SuperAdmin123!");
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
