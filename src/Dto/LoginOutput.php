<?php

declare(strict_types=1);


namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class LoginOutput
{
    public function __construct(
        #[Groups(['login_read'])]
        public readonly string $token,
    ) {}
}