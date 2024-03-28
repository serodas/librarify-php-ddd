<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Domain;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounter;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterId;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterIncrementedDomainEvent;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterTotal;

final class BooksCounterIncrementedDomainEventMother
{
    public static function create(
        ?BooksCounterId $id = null,
        ?BooksCounterTotal $total = null
    ): BooksCounterIncrementedDomainEvent {
        return new BooksCounterIncrementedDomainEvent(
            $id?->value() ?? BooksCounterIdMother::create()->value(),
            $total?->value() ?? BooksCounterTotalMother::create()->value()
        );
    }

    public static function fromCounter(BooksCounter $counter): BooksCounterIncrementedDomainEvent
    {
        return self::create($counter->id(), $counter->total());
    }
}