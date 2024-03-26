<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Domain;

use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class BookTitleMother
{
    public static function create(?string $value = null): BookTitle
    {
        return new BookTitle($value ?? WordMother::create());
    }
}
