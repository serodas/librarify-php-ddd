<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Controller\Auth;

use Firebase\JWT\JWT;
use MyLibrary\Librarify\Auth\Application\Authenticate\UserAuthenticator;
use MyLibrary\Librarify\Auth\Domain\AuthPassword;
use MyLibrary\Librarify\Auth\Domain\AuthUsername;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class AuthUsersPostController
{
    public function __construct(
        private UserAuthenticator $authenticator,
        private ParameterBagInterface $params
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $username = (string) $request->request->get('username');
        $password = (string) $request->request->get('password');
        $username = new AuthUsername($username);
        $password = new AuthPassword($password);

        $this->authenticator->authenticate($username, $password);
        $authUser = $this->authenticator->getAuthUser($username);
        $token = $this->generateToken($authUser->id()->value());
        return new JsonResponse(['token' => $token]);
    }

    private function generateToken(string $authId): string
    {
        $payload = [
            'iss'       => 'librarify.com',
            'aud'       => 'librarify.com',
            'iat'       => time(),
            'exp'       => time() + (60 * 60),
            'authId'    => $authId
        ];

        $jwtSecret = $this->params->get('JWT_SECRET');
        return JWT::encode($payload, $jwtSecret, 'HS256');
    }

    protected function exceptions(): array
    {
        return [];
    }
}
