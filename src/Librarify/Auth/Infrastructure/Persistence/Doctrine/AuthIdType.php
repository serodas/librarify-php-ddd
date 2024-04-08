<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\Shared\Domain\Auth\AuthId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class AuthIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return AuthId::class;
    }
}
