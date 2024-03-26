<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Domain;

use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookCreatedDomainEvent;
use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;

final class BookCreatedDomainEventMother
{
    public static function create(
        ?BookId $id = null,
        ?BookTitle $title = null,
        ?BookDescription $description = null,
        ?BookScore $score = null,
    ): BookCreatedDomainEvent {
        return new BookCreatedDomainEvent(
            $id?->value() ?? BookIdMother::create()->value(),
            $title?->value() ?? BookTitleMother::create()->value(),
            $description?->value() ?? BookDescriptionMother::create()->value(),
            $score?->value() ?? BookScoreMother::create()->value()
        );
    }

    public static function fromBook(Book $book): BookCreatedDomainEvent
    {
        return self::create($book->id(), $book->title(), $book->description(), $book->score());
    }
}
