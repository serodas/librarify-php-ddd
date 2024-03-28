<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Application\Increment;

use MyLibrary\Librarify\Books\Domain\BookCreatedDomainEvent;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Domain\Bus\Event\DomainEventSubscriber;
use function Lambdish\Phunctional\apply;

final class IncrementBooksCounterOnBookCreated implements DomainEventSubscriber
{
    public function __construct(private readonly BooksCounterIncrementer $incrementer)
    {
    }

    public static function subscribedTo(): array
    {
        return [BookCreatedDomainEvent::class];
    }

    public function __invoke(BookCreatedDomainEvent $event): void
    {
        $bookId = new BookId($event->aggregateId());

        apply($this->incrementer, [$bookId]);
    }
}