<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class BookIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return BookId::class;
    }
}
