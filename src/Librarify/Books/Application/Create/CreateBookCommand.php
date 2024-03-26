<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Application\Create;

use MyLibrary\Shared\Domain\Bus\Command\Command;

final class CreateBookCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $description,
        private readonly int $score,
        private readonly array $authors,
        private readonly array $categories
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

    public function authors(): array
    {
        return $this->authors;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
