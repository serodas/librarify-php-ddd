<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class AuthorIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return AuthorId::class;
    }
}
