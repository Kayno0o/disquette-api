<?php

declare(strict_types=1);


namespace App\Entity\Behavior;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;

trait TimestampableTrait
{
    #[Timestampable(on: 'create')]
    #[Column(type: Types::DATETIME_MUTABLE), Groups(['timestampable_read'])]
    public DateTime $createdAt;

    #[Timestampable(on: "update")]
    #[Column(type: Types::DATETIME_MUTABLE), Groups(['timestampable_read'])]
    public DateTime $updatedAt;
}
