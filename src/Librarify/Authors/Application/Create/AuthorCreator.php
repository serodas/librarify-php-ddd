<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Create;

use MyLibrary\Librarify\Authors\Domain\Author;
use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Domain\Bus\Event\EventBus;

final class AuthorCreator
{
    public function __construct(private readonly AuthorRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(AuthorId $id, AuthorName $name): void
    {
        $author = Author::create($id, $name);

        $this->repository->save($author);
        $this->bus->publish(...$author->pullDomainEvents());
    }
}
