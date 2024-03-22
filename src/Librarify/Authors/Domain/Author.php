<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Domain;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Domain\Aggregate\AggregateRoot;

final class Author extends AggregateRoot
{
    public function __construct(private readonly AuthorId $id, private AuthorName $name)
    {
    }

    public static function create(AuthorId $id, AuthorName $name): self
    {
        $author = new self($id, $name);

        $author->record(new AuthorCreatedDomainEvent($id->value(), $name->value()));

        return $author;
    }

    public function id(): AuthorId
    {
        return $this->id;
    }

    public function name(): AuthorName
    {
        return $this->name;
    }
}
