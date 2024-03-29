<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Application;

use MyLibrary\Shared\Domain\Bus\Query\Response;

final class BackofficeBooksResponse implements Response
{
    private readonly array $books;

    public function __construct(BackofficeBookResponse ...$books)
    {
        $this->books = $books;
    }

    public function books(): array
    {
        return $this->books;
    }
}
