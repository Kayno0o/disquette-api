<?php

declare(strict_types=1);


namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\Behavior\DefaultEntityTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Entity]
#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_ADMIN')"),
        new Get(
            uriTemplate: "/people/me",
            security: "is_granted('ROLE_USER')",
            openapiContext: [
                'summary' => 'Get the current user',
                'description' => 'Get the current user',
            ],
        ),
        new Get(security: "object.id == user.id or is_granted('ROLE_ADMIN')"),
        new Post(security: "is_granted('ROLE_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['user_read']],
    denormalizationContext: ['groups' => ['user_write']],
)]
class Person implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DefaultEntityTrait;

    #[Column(unique: true)]
    public ?string $email = null;

    #[Column]
    private ?string $password = null;

    #[Column(type: 'json')]
    private array $roles;

    public function __construct(
        #[Column]
        public string $username = '',
    ) {
        $this->setRoles([]);
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $string): bool
    {
        return in_array($string, $this->getRoles(), true);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }


}
