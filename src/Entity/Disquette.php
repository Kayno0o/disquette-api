<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\Behavior\DefaultEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
#[ApiResource(
    shortName: '/admin/disquette',
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['disquette_read']],
    denormalizationContext: ['groups' => ['disquette_write']],
    filters: [],
    security: 'is_granted("ROLE_ADMIN")'
)]
class Disquette
{
    use DefaultEntityTrait;

    #[ManyToMany(targetEntity: Tag::class)]
    #[Groups(['disquette_read', 'disquette_write'])]
    private Collection $tags;

    public function __construct(
        #[ManyToOne(targetEntity: Person::class)]
        #[Groups(['disquette_read', 'disquette_write'])]
        public Person $person,

        #[Column(type: 'boolean', nullable: false)]
        #[Groups(['disquette_read', 'disquette_write'])]
        public bool $isOC,

        #[Column(type: 'string', nullable: false)]
        #[Groups(['disquette_read', 'disquette_write'])]
        public string $content,
    ) {
        $this->tags = new ArrayCollection();
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): void
    {
        $this->tags->add($tag);
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags->getValues();
    }
}
