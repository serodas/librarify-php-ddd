<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Domain;

use MyLibrary\Librarify\Books\Application\Create\CreateBookCommand;
use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorIdMother;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryIdMother;
use MyLibrary\Tests\Shared\Domain\Repeater;

final class BookMother
{
    public static function create(
        ?BookId $id = null,
        ?BookTitle $title = null,
        ?BookDescription $description = null,
        ?BookScore $score = null,
        ?array $authors = [],
        ?array $categories = []
    ): Book {
        return new Book(
            $id ?? BookIdMother::create(),
            $title ?? BookTitleMother::create(),
            $description ?? BookDescriptionMother::create(),
            $score ?? BookScoreMother::create(),
            count($authors) ? $authors : Repeater::random(fn () => AuthorIdMother::create()),
            count($categories) ? $categories : Repeater::random(fn () => CategoryIdMother::create())
        );
    }

    public static function fromRequest(CreateBookCommand $request): Book
    {
        return self::create(
            BookIdMother::create($request->id()),
            BookTitleMother::create($request->title()),
            BookDescriptionMother::create($request->description()),
            BookScoreMother::create($request->score()),
            $request->authors(),
            $request->categories()
        );
    }
}
