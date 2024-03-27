<?php

declare(strict_types = 1);

namespace MyLibrary\Librarify\Authors\Domain;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;

final class AuthorFinder
{
    private $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AuthorId $id): Author
    {
        $author = $this->repository->search($id);

        $this->ensureAuthorExists($id, $author);

        return $author;
    }

    private function ensureAuthorExists(AuthorId $id, Author $author = null): void
    {
        if (null === $author) {
            throw new AuthorNotFound($id);
        }
    }
}