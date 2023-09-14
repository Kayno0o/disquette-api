<?php

declare(strict_types=1);


namespace App\Entity\Behavior;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Gedmo\Mapping\Annotation\SoftDeleteable;

#[SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
trait SoftDeletableTrait
{
    #[Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $deletedAt;

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}
