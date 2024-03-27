<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Application\Find;

use MyLibrary\Librarify\Authors\Application\Find\AuthorResponse;
use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorIdMother;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorNameMother;

final class AuthorResponseMother
{
    public static function create(
        AuthorId $id,
        AuthorName $name,
    ): AuthorResponse {
        return new AuthorResponse($id->value(), $name->value());
    }

    public static function withId(AuthorId $id): AuthorResponse
    {
        return self::create($id, AuthorNameMother::create());
    }

    public static function random(): AuthorResponse
    {
        return self::create(
            AuthorIdMother::random(),
            AuthorNameMother::create(),
        );
    }
}
