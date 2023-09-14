<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsController]
abstract class AbstractController extends Controller
{
    use HandleTrait;

    /**
     * AbstractResourceDataPersister constructor.
     *
     * @param MessageBusInterface $commandBus
     * @param Security            $security
     */
    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly Security $security,
    ) {}

    /**
     * @param $command
     *
     * @return mixed
     */
    protected function executeCommand($command): mixed
    {
        $this->messageBus = $this->commandBus;

        return $this->handle($command);
    }
}
