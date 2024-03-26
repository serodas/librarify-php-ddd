<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Domain;

use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class BookDescriptionMother
{
    public static function create(?string $value = null): BookDescription
    {
        return new BookDescription($value ?? WordMother::create());
    }
}
