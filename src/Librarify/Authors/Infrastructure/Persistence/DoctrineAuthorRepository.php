<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Infrastructure\Persistence;

use MyLibrary\Librarify\Authors\Domain\Author;
use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineAuthorRepository extends DoctrineRepository implements AuthorRepository
{
    public function save(Author $author): void
    {
        $this->persist($author);
    }

    public function search(AuthorId $id): ?Author
    {
        return $this->repository(Author::class)->find($id);
    }
}
