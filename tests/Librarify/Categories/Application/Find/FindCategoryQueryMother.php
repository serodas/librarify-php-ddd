<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Application\Find;

use MyLibrary\Librarify\Categories\Application\Find\FindCategoryQuery;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryIdMother;

final class FindCategoryQueryMother
{
    public static function create(CategoryId $id): FindCategoryQuery
    {
        return new FindCategoryQuery($id->value());
    }

    public static function random(): FindCategoryQuery
    {
        return self::create(CategoryIdMother::random());
    }
}
