<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Application\Create;

use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Librarify\Books\Domain\BookRepository;
use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Domain\Bus\Event\EventBus;

final class BookCreator
{
    public function __construct(private readonly BookRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(
        BookId $id,
        BookTitle $title,
        BookDescription $description,
        BookScore $score,
        $authors,
        $categories
    ): void {
        $book = $this->repository->search($id);

        if (null === $book) {
            $book = Book::create($id, $title, $description, $score, $authors, $categories);
        }

        $this->repository->save($book);
        $this->bus->publish(...$book->pullDomainEvents());
    }
}
