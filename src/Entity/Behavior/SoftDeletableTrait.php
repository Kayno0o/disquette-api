<?php

declare(strict_types=1);


namespace App\Entity\Behavior;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Gedmo\Mapping\Annotation\SoftDeleteable;

#[SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
trait SoftDeletableTrait
{
    #[Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    public $deletedAt;
}
