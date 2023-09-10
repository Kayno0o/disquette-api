<?php

declare(strict_types=1);


namespace App\Entity\Behavior;


trait DefaultEntityTrait
{
    use IdentifiableTrait;
    use SoftDeletableTrait;
    use TimestampableTrait;
}