<?php

declare(strict_types=1);

namespace MyLibrary\Shared\Infrastructure\Symfony;

use MyLibrary\Backoffice\Auth\Application\Authenticate\AuthenticateUserCommand;
use MyLibrary\Backoffice\Auth\Domain\InvalidAuthCredentials;
use MyLibrary\Backoffice\Auth\Domain\InvalidAuthUsername;
use MyLibrary\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class BasicHttpAuthMiddleware
{
    public function __construct(private readonly CommandBus $bus)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $shouldAuthenticate = $event->getRequest()->attributes->get('auth', false);

        if ($shouldAuthenticate) {
            $user = $event->getRequest()->headers->get('php-auth-user');
            $pass = $event->getRequest()->headers->get('php-auth-pw');

            $this->hasIntroducedCredentials($user)
                ? $this->authenticate($user, $pass, $event)
                : $this->askForCredentials($event);
        }
    }

    private function hasIntroducedCredentials(?string $user): bool
    {
        return null !== $user;
    }

    private function authenticate(string $user, string $pass, RequestEvent $event): void
    {
        try {
            $this->bus->dispatch(new AuthenticateUserCommand($user, $pass));

            $this->addUserDataToRequest($user, $event);
        } catch (InvalidAuthUsername | InvalidAuthCredentials) {
            $event->setResponse(new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_FORBIDDEN));
        }
    }

    private function addUserDataToRequest(string $user, RequestEvent $event): void
    {
        $event->getRequest()->attributes->set('authenticated_username', $user);
    }

    private function askForCredentials(RequestEvent $event): void
    {
        $event->setResponse(
            new Response('', Response::HTTP_UNAUTHORIZED, ['WWW-Authenticate' => 'Basic realm="MyLibrary"'])
        );
    }
}
