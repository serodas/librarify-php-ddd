<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Domain;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\Aggregate\AggregateRoot;

final class Category extends AggregateRoot
{
    public function __construct(private readonly CategoryId $id, private CategoryName $name)
    {
    }

    public static function create(CategoryId $id, CategoryName $name): self
    {
        $author = new self($id, $name);

        $author->record(new CategoryCreatedDomainEvent($id->value(), $name->value()));

        return $author;
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function name(): CategoryName
    {
        return $this->name;
    }
}
