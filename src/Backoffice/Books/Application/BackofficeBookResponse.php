<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Application;

final class BackofficeBookResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $description,
        private readonly int $score
    ) {
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
