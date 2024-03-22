<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Domain;

use MyLibrary\Librarify\Authors\Application\Create\CreateAuthorCommand;
use MyLibrary\Librarify\Authors\Domain\Author;
use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;

final class AuthorMother
{
    public static function create(
        ?AuthorId $id = null,
        ?AuthorName $name = null,
    ): Author {
        return new Author(
            $id ?? AuthorIdMother::random(),
            $name ?? AuthorNameMother::create(),
        );
    }

    public static function fromRequest(CreateAuthorCommand $request): Author
    {
        return self::create(
            AuthorIdMother::create($request->id()),
            AuthorNameMother::create($request->name()),
        );
    }
}
