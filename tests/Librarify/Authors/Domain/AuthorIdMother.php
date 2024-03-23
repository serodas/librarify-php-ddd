<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Domain;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Tests\Shared\Domain\UuidMother;

final class AuthorIdMother
{
    public static function create(?string $value = null): AuthorId
    {
        return new AuthorId($value ?? UuidMother::create());
    }

    public static function random(): AuthorId
    {
        return self::create(UuidMother::create());
    }
}
