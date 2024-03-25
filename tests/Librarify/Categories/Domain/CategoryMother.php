<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Domain;

use MyLibrary\Librarify\Categories\Application\Create\CreateCategoryCommand;
use MyLibrary\Librarify\Categories\Domain\Category;
use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;

final class CategoryMother
{
    public static function create(
        ?CategoryId $id = null,
        ?CategoryName $name = null,
    ): Category {
        return new Category(
            $id ?? CategoryIdMother::random(),
            $name ?? CategoryNameMother::create(),
        );
    }

    public static function fromRequest(CreateCategoryCommand $request): Category
    {
        return self::create(
            CategoryIdMother::create($request->id()),
            CategoryNameMother::create($request->name()),
        );
    }
}
