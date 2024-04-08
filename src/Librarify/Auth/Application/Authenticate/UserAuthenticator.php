<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Application\Authenticate;

use MyLibrary\Librarify\Auth\Domain\AuthPassword;
use MyLibrary\Librarify\Auth\Domain\AuthRepository;
use MyLibrary\Librarify\Auth\Domain\AuthUser;
use MyLibrary\Librarify\Auth\Domain\AuthUsername;
use MyLibrary\Librarify\Auth\Domain\InvalidAuthCredentials;
use MyLibrary\Librarify\Auth\Domain\InvalidAuthUsername;

final class UserAuthenticator
{
    public function __construct(private readonly AuthRepository $repository)
    {
    }

    public function authenticate(AuthUsername $username, AuthPassword $password): void
    {
        $auth = $this->repository->search($username);
        $this->ensureUserExist($auth, $username);
        $this->ensureCredentialsAreValid($auth, $password);
    }

    public function getAuthUser(AuthUsername $username): AuthUser
    {
        $auth = $this->repository->search($username);
        $this->ensureUserExist($auth, $username);
        return $auth;
    }

    private function ensureUserExist(?AuthUser $auth, AuthUsername $username): void
    {
        if (null === $auth) {
            throw new InvalidAuthUsername($username);
        }
    }

    private function ensureCredentialsAreValid(AuthUser $auth, AuthPassword $password): void
    {
        if (!$auth->passwordMatches($password)) {
            throw new InvalidAuthCredentials($auth->username());
        }
    }
}
