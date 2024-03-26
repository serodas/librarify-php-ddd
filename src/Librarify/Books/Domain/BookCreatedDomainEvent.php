<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Domain;

use MyLibrary\Shared\Domain\Bus\Event\DomainEvent;

final class BookCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $title,
        private readonly string $description,
        private readonly int $score,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'book.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['title'], $body['description'], $body['score'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'title'     => $this->title,
            'description' => $this->description,
            'score' => $this->score,
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function score(): int
    {
        return $this->score;
    }
}
