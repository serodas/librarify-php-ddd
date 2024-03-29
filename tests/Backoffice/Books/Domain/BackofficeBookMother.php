<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Backoffice\Books\Domain;

use MyLibrary\Backoffice\Books\Domain\BackofficeBook;
use MyLibrary\Tests\Librarify\Books\Domain\BookDescriptionMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookIdMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookScoreMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookTitleMother;

final class BackofficeBookMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $description = null,
        ?int $score = null
    ): BackofficeBook {
        return new BackofficeBook(
            $id ?? BookIdMother::create()->value(),
            $title ?? BookTitleMother::create()->value(),
            $description ?? BookDescriptionMother::create()->value(),
            $score ?? BookScoreMother::create()->value()
        );
    }
}
