<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Infrastructure\Persistence;

use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookRepository;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineBookRepository extends DoctrineRepository implements BookRepository
{
    public function save(Book $book): void
    {
        $this->persist($book);
    }

    public function search(BookId $id): ?Book
    {
        return $this->repository(Book::class)->find($id);
    }
}
