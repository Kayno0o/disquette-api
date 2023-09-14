<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Person;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @throws Exception
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Person) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof Person) {
            return;
        }

        if ($user->isDeleted()) {
            throw new CustomUserMessageAccountStatusException(
                message: 'disabledUser',
                code: Response::HTTP_UNAUTHORIZED,
            );
        }
    }
}
