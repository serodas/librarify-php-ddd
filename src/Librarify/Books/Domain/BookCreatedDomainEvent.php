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
        private readonly array $authors,
        private readonly array $categories,
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
        return new self($aggregateId, $body['title'], $body['description'], $body['score'], $body['authors'], $body['categories'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'title'     => $this->title,
            'description' => $this->description,
            'score' => $this->score,
            'authors' => $this->authors,
            'categories' => $this->categories,
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

    public function authors(): array
    {
        return $this->authors;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
