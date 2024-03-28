<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Domain;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterId;
use MyLibrary\Tests\Shared\Domain\UuidMother;

final class BooksCounterIdMother
{
    public static function create(?string $value = null): BooksCounterId
    {
        return new BooksCounterId($value ?? UuidMother::create());
    }
}
