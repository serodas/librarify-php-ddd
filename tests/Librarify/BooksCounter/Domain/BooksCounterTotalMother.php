<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Domain;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterTotal;
use MyLibrary\Tests\Shared\Domain\IntegerMother;

final class BooksCounterTotalMother
{
    public static function create(?int $value = null): BooksCounterTotal
    {
        return new BooksCounterTotal($value ?? IntegerMother::create());
    }

    public static function one(): BooksCounterTotal
    {
        return self::create(1);
    }

    public static function random(): BooksCounterTotal
    {
        return self::create(IntegerMother::create());
    }
}