<?php

declare(strict_types=1);


namespace App\Command\Person;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LoginCommandHandler
{
    public function __construct(
        private readonly JWTTokenManagerInterface $JWTTokenManager,
    ) {}

    public function __invoke(LoginCommand $command): JsonResponse
    {
        $person = $command->getPerson();
    }
}