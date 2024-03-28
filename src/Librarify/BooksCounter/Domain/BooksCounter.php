<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Domain;

use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Domain\Aggregate\AggregateRoot;
use function Lambdish\Phunctional\search;

final class BooksCounter extends AggregateRoot
{
    private array $existingBooks;

    public function __construct(
        private readonly BooksCounterId $id,
        private BooksCounterTotal $total,
        BookId ...$existingBooks
    ) {
        $this->existingBooks = $existingBooks;
    }

    public static function initialize(BooksCounterId $id): self
    {
        return new self($id, BooksCounterTotal::initialize());
    }

    public function id(): BooksCounterId
    {
        return $this->id;
    }

    public function total(): BooksCounterTotal
    {
        return $this->total;
    }

    public function existingBooks(): array
    {
        return $this->existingBooks;
    }

    public function increment(BookId $bookId): void
    {
        $this->total             = $this->total->increment();
        $this->existingBooks[]   = $bookId;

        $this->record(new BooksCounterIncrementedDomainEvent($this->id()->value(), $this->total()->value()));
    }

    public function hasIncremented(BookId $bookId): bool
    {
        $existingBook = search($this->BookIdComparator($bookId), $this->existingBooks());

        return null !== $existingBook;
    }

    private function BookIdComparator(BookId $bookId): callable
    {
        return static fn (BookId $other) => $bookId->equals($other);
    }
}
