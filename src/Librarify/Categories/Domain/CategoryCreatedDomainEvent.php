<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Domain;

use MyLibrary\Shared\Domain\Bus\Event\DomainEvent;

final class CategoryCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $name,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'category.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['name'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'name'     => $this->name,
        ];
    }

    public function name(): string
    {
        return $this->name;
    }
}
