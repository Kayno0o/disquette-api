<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly JWTTokenManagerInterface $JWTTokenManager
    ) {}

    #[Route('/api/login', name: 'api_login')]
    public function login(?Person $person): Response
    {
        if ($person === null) {
            return $this->json(['message' => 'missing_credentials'], Response::HTTP_UNAUTHORIZED);
        }
        $token = $this->JWTTokenManager->create($person);
        return $this->json(['user' => $person, 'token' => $token]);
    }
}
