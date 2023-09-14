<?php

declare(strict_types=1);


namespace App\Command\Person;

use App\Entity\Person;

class LoginCommand
{
    public function __construct(
        private readonly ?Person $person = null,
    ) {}

    /**
     * @return ?Person
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }
}