<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Domain;

use MyLibrary\Librarify\Shared\Domain\Auth\AuthId;
use MyLibrary\Shared\Domain\Aggregate\AggregateRoot;

final class AuthUser extends AggregateRoot
{
    public function __construct(
        private readonly AuthId $id,
        private AuthUsername $username,
        private AuthPassword $password
    ) {
    }

    public function passwordMatches(AuthPassword $password): bool
    {
        return $this->password->isEquals($password);
    }

    public function id(): AuthId
    {
        return $this->id;
    }

    public function username(): AuthUsername
    {
        return $this->username;
    }

    public function password(): AuthPassword
    {
        return $this->password;
    }
}
