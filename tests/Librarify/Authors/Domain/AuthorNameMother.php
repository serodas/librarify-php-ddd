<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Domain;

use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class AuthorNameMother
{
    public static function create(?string $value = null): AuthorName
    {
        return new AuthorName($value ?? WordMother::create());
    }
}
