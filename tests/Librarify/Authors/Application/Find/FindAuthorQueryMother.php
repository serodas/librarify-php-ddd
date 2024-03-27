<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Application\Find;

use MyLibrary\Librarify\Authors\Application\Find\FindAuthorQuery;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorIdMother;

final class FindAuthorQueryMother
{
    public static function create(AuthorId $id): FindAuthorQuery
    {
        return new FindAuthorQuery($id->value());
    }

    public static function random(): FindAuthorQuery
    {
        return self::create(AuthorIdMother::random());
    }
}
