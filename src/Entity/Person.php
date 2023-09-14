<?php

declare(strict_types=1);


namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Entity\Behavior\DefaultEntityTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_SUPER_ADMIN')",
        ),
        new Get(
            uriTemplate: "/me",
            openapiContext: [
                'summary' => 'Get the current user',
                'description' => 'Get the current user',
            ],
            security: "is_granted('ROLE_USER')",
        ),
        new Get(
            security: "object.id == user.id or is_granted('ROLE_SUPER_ADMIN')",
        ),
        new Put(
            security: "object.id == user.id or is_granted('ROLE_SUPER_ADMIN')",
        ),
        new Post(
            security: "is_granted('ROLE_SUPER_ADMIN')",
        ),
    ],
    normalizationContext: ['groups' => ['person_read']],
    denormalizationContext: ['groups' => ['person_write']],
)]
class Person implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DefaultEntityTrait;

    public const DEFAULT_ROLE = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    #[Column]
    private ?string $password = null;

    #[Column(type: 'json')]
    private array $roles = [];

    public function __construct(
        #[Column]
        #[Groups(['person_read', 'person_write'])]
        public string $username = '',

        #[Column(unique: true)]
        public ?string $email = null,

        array $roles = [],
    ) {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    #[Groups(['person_read'])]
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        if ($role === 'ROLE_USER') {
            return true;
        }
        return in_array($role, $this->roles, true);
    }

    public function addRole(string $role): void
    {
        if ($role === 'ROLE_USER' || in_array($role, $this->roles, true)) {
            return;
        }

        $this->roles[] = $role;
    }
}
