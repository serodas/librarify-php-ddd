<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Application\Find;

use MyLibrary\Librarify\Categories\Application\Find\CategoryResponse;
use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryIdMother;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryNameMother;

final class CategoryResponseMother
{
    public static function create(
        CategoryId $id,
        CategoryName $name,
    ): CategoryResponse {
        return new CategoryResponse($id->value(), $name->value());
    }

    public static function withId(CategoryId $id): CategoryResponse
    {
        return self::create($id, CategoryNameMother::create());
    }

    public static function random(): CategoryResponse
    {
        return self::create(
            CategoryIdMother::random(),
            CategoryNameMother::create(),
        );
    }
}
