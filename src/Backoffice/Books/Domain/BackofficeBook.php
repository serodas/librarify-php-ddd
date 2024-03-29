<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Domain;

use MyLibrary\Shared\Domain\Aggregate\AggregateRoot;

final class BackofficeBook extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $description,
        private readonly int $score
    ) {
    }

    public static function fromPrimitives(array $primitives): BackofficeBook
    {
        return new self($primitives['id'], $primitives['title'], $primitives['description'], $primitives['score']);
    }

    public function toPrimitives(): array
    {
        return [
            'id'       => $this->id,
            'title'     => $this->title,
            'description' => $this->description,
            'score' => $this->score
        ];
    }

    public function id(): string
    {
        return $this->id;
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
