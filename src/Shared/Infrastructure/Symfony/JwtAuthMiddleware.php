<?php

declare(strict_types=1);

namespace MyLibrary\Shared\Infrastructure\Symfony;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class JwtAuthMiddleware
{
    public function __construct(private ParameterBagInterface $params)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $shouldAuthenticate = $event->getRequest()->attributes->get('auth', false);
        if ($shouldAuthenticate) {
            $authorizationHeader = $event->getRequest()->headers->get('Authorization', '');
            $token = str_replace('Bearer ', '', $authorizationHeader) ?: null;
            $this->hasIntroducedAuthorizationToken($token)
                ? $this->authenticate($token, $event)
                : $this->askForAuthorizationToken($event);
        }
    }

    private function hasIntroducedAuthorizationToken(?string $token): bool
    {
        return null !== $token;
    }

    private function authenticate(string $token, RequestEvent $event): void
    {
        try {
            $tokenDecoded = $this->decodeToken($token);
            $this->addUserDataToRequest($tokenDecoded, $event);
        } catch (Exception $e) {
            $event->setResponse(new JsonResponse(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED));
        }
    }

    private function addUserDataToRequest(stdClass $tokenDecoded, RequestEvent $event): void
    {
        $event->getRequest()->attributes->set('tokenDecoded', $tokenDecoded);
    }

    private function askForAuthorizationToken(RequestEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(['error' => 'You must provide authorization token'], Response::HTTP_UNAUTHORIZED)
        );
    }

    private function decodeToken(string $token): \stdClass
    {
        try {
            $key = new Key($this->params->get('JWT_SECRET'), 'HS256');
            $decoded = JWT::decode($token, $key);
            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
