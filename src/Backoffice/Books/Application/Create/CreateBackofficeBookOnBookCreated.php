<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Application\Create;

use MyLibrary\Librarify\Books\Domain\BookCreatedDomainEvent;
use MyLibrary\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CreateBackofficeBookOnBookCreated implements DomainEventSubscriber
{
    public function __construct(private readonly BackofficeBookCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [BookCreatedDomainEvent::class];
    }

    public function __invoke(BookCreatedDomainEvent $event): void
    {
        $this->creator->create($event->aggregateId(), $event->title(), $event->description(), $event->score());
    }
}
