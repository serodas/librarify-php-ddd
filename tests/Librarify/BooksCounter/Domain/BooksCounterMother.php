<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Domain;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounter;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterId;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterTotal;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Tests\Librarify\Books\Domain\BookIdMother;
use MyLibrary\Tests\Shared\Domain\Repeater;

final class BooksCounterMother
{
    public static function create(
        ?BooksCounterId $id = null,
        ?BooksCounterTotal $total = null,
        BookId ...$existingBooks
    ): BooksCounter {
        return new BooksCounter(
            $id ?? BooksCounterIdMother::create(),
            $total ?? BooksCounterTotalMother::create(),
            ...count($existingBooks) ? $existingBooks : Repeater::random(fn () => BookIdMother::create())
        );
    }

    public static function withOne(BookId $bookId): BooksCounter
    {
        return self::create(BooksCounterIdMother::create(), BooksCounterTotalMother::one(), $bookId);
    }

    public static function incrementing(BooksCounter $existingCounter, BookId $bookId): BooksCounter
    {
        return self::create(
            $existingCounter->id(),
            BooksCounterTotalMother::create($existingCounter->total()->value() + 1),
            ...array_merge($existingCounter->existingBooks(), [$bookId])
        );
    }
}
