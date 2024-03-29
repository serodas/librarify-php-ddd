<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Domain;

use MyLibrary\Shared\Domain\Criteria\Criteria;

interface BackofficeBookRepository
{
    public function save(BackofficeBook $book): void;

    public function searchAll(): array;

    public function matching(Criteria $criteria): array;
}
