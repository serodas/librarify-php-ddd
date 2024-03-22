<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Domain;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;

interface AuthorRepository
{
    public function save(Author $author): void;

    public function search(AuthorId $id): ?Author;
}
