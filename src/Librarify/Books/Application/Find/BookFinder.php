<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Application\Find;

use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookNotFound;
use MyLibrary\Librarify\Books\Domain\BookRepository;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;

final class BookFinder
{
    public function __construct(private readonly BookRepository $repository)
    {
    }

    public function __invoke(BookId $id): Book
    {
        $book = $this->repository->search($id);

        if (null === $book) {
            throw new BookNotFound($id);
        }

        return $book;
    }
}