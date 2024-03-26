<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Domain;

use MyLibrary\Librarify\Shared\Domain\Books\BookId;

interface BookRepository
{
    public function save(Book $book): void;

    public function search(BookId $id): ?Book;
}
