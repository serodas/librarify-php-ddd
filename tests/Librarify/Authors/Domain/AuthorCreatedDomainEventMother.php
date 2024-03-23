<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Domain;

use MyLibrary\Librarify\Authors\Domain\Author;
use MyLibrary\Librarify\Authors\Domain\AuthorCreatedDomainEvent;
use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;

final class AuthorCreatedDomainEventMother
{
    public static function create(
        ?AuthorId $id = null,
        ?AuthorName $name = null,
    ): AuthorCreatedDomainEvent {
        return new AuthorCreatedDomainEvent(
            $id?->value() ?? AuthorIdMother::create()->value(),
            $name?->value() ?? AuthorNameMother::create()->value(),
        );
    }

    public static function fromAuthor(Author $author): AuthorCreatedDomainEvent
    {
        return self::create($author->id(), $author->name());
    }
}
