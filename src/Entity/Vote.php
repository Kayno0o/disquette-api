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
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['vote_read']],
    denormalizationContext: ['groups' => ['vote_write']],
)]
#[UniqueEntity(
    fields: ['person', 'disquette'],
    message: 'This person has already voted this disquette.',
    errorPath: 'person',
)]
class Vote
{
    use DefaultEntityTrait;

    public function __construct(
        #[ManyToOne(targetEntity: Person::class)]
        #[Groups(['vote_read', 'vote_write'])]
        public Person $person,

        #[ManyToOne(targetEntity: Disquette::class)]
        #[Groups(['vote_read', 'vote_write'])]
        public Disquette $disquette,

        #[Column(type: 'boolean', nullable: false)]
        #[Groups(['disquette_read', 'disquette_write'])]
        public bool $up,
    ) {}
}