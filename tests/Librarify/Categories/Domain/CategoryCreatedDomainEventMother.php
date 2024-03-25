<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Domain;

use MyLibrary\Librarify\Categories\Domain\Category;
use MyLibrary\Librarify\Categories\Domain\CategoryCreatedDomainEvent;
use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;

final class CategoryCreatedDomainEventMother
{
    public static function create(
        ?CategoryId $id = null,
        ?CategoryName $name = null,
    ): CategoryCreatedDomainEvent {
        return new CategoryCreatedDomainEvent(
            $id?->value() ?? CategoryIdMother::create()->value(),
            $name?->value() ?? CategoryNameMother::create()->value(),
        );
    }

    public static function fromCategory(Category $author): CategoryCreatedDomainEvent
    {
        return self::create($author->id(), $author->name());
    }
}
