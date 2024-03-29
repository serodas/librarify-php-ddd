<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Application\Create;

use MyLibrary\Backoffice\Books\Domain\BackofficeBook;
use MyLibrary\Backoffice\Books\Domain\BackofficeBookRepository;

final class BackofficeBookCreator
{
    public function __construct(private readonly BackofficeBookRepository $repository)
    {
    }

    public function create(string $id, string $title, string $description, int $score): void
    {
        $this->repository->save(new BackofficeBook($id, $title, $description, $score));
    }
}
