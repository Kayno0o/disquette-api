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
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['tag_read']],
    denormalizationContext: ['groups' => ['tag_write']],
)]
class Tag
{
    use DefaultEntityTrait;

    public function __construct(
        #[Column(type: 'string', nullable: false)]
        #[Groups(['tag_read', 'tag_write'])]
        public string $code,

        #[Column(type: 'string', nullable: false)]
        #[Groups(['tag_read', 'tag_write'])]
        public string $label,
    ) {}
}