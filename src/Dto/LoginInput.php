<?php

declare(strict_types=1);


namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class LoginInput
{
    public function __construct(
        #[Groups(['login_write'])]
        public readonly string $email,

        #[Groups(['login_write'])]
        public readonly string $password,
    ) {}
}