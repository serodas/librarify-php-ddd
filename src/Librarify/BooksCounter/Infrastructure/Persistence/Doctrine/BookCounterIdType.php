<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class BookCounterIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return BooksCounterId::class;
    }
}