<?php

declare(strict_types=1);


namespace App\Controller;

use App\Entity\Person;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class PersonLoginController extends AbstractController
{
    public function __construct(
        MessageBusInterface $commandBus,
        Security $security,
        private readonly JWTTokenManagerInterface $JWTTokenManager,
    ) {
        parent::__construct($commandBus, $security);
    }

    #[Route('/api/loginb', name: 'api_loginb', methods: "POST")]
    public function login(Request $request, ?Person $person): Response
    {
        if ($person === null) {
            return new JsonResponse(['message' => 'missing_credentials'], Response::HTTP_UNAUTHORIZED);
        }
        $token = $this->JWTTokenManager->create($person);
        return new JsonResponse(['user' => $person, 'token' => $token]);
    }
}
