<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use MyLibrary\Librarify\Books\Domain\BookCreatedDomainEvent;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterIncrementedDomainEvent;
use MyLibrary\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class TestAllWorksOnRabbitMqEventsPublished implements DomainEventSubscriber
{
    public static function subscribedTo(): array
    {
        return [
            BookCreatedDomainEvent::class,
            BooksCounterIncrementedDomainEvent::class,
        ];
    }

    public function __invoke(BookCreatedDomainEvent|BooksCounterIncrementedDomainEvent $event): void
    {
    }
}
