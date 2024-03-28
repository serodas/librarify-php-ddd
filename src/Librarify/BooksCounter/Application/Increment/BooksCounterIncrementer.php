<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Application\Increment;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounter;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterId;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterRepository;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Domain\Bus\Event\EventBus;
use MyLibrary\Shared\Domain\UuidGenerator;

final class BooksCounterIncrementer
{
    public function __construct(
        private readonly BooksCounterRepository $repository,
        private readonly UuidGenerator $uuidGenerator,
        private readonly EventBus $bus
    ) {
    }

    public function __invoke(BookId $bookId): void
    {
        $counter = $this->repository->search() ?: $this->initializeCounter();

        if (!$counter->hasIncremented($bookId)) {
            $counter->increment($bookId);

            $this->repository->save($counter);
            $this->bus->publish(...$counter->pullDomainEvents());
        }
    }

    private function initializeCounter(): BooksCounter
    {
        return BooksCounter::initialize(new BooksCounterId($this->uuidGenerator->generate()));
    }
}