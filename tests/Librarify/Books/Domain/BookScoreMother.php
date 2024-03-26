<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Domain;

use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Tests\Shared\Domain\IntegerMother;

final class BookScoreMother
{
    public static function create(?int $value = null): BookScore
    {
        return new BookScore($value ?? IntegerMother::between(1, 10));
    }
}
