<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Application\Create;

use MyLibrary\Librarify\Books\Application\Create\CreateBookCommand;
use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorIdMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookDescriptionMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookIdMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookScoreMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookTitleMother;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryIdMother;
use MyLibrary\Tests\Shared\Domain\Repeater;

final class CreateBookCommandMother
{
    public static function create(
        ?BookId $id = null,
        ?BookTitle $title = null,
        ?BookDescription $description = null,
        ?BookScore $score = null,
        ?array $authors = [],
        ?array $categories = []
    ): CreateBookCommand {
        return new CreateBookCommand(
            $id?->value() ?? BookIdMother::create()->value(),
            $title?->value() ?? BookTitleMother::create()->value(),
            $description?->value() ?? BookDescriptionMother::create()->value(),
            $score?->value() ?? BookScoreMother::create()->value(),
            count($authors) ? $authors : Repeater::random(fn () => AuthorIdMother::create()),
            count($categories) ? $categories : Repeater::random(fn () => CategoryIdMother::create())
        );
    }
}
