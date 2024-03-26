<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Domain;

use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Tests\Shared\Domain\UuidMother;

final class BookIdMother
{
    public static function create(?string $value = null): BookId
    {
        return new BookId($value ?? UuidMother::create());
    }

    public static function random(): BookId
    {
        return self::create(UuidMother::create());
    }
}
