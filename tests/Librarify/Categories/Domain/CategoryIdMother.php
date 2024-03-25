<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Domain;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Tests\Shared\Domain\UuidMother;

final class CategoryIdMother
{
    public static function create(?string $value = null): CategoryId
    {
        return new CategoryId($value ?? UuidMother::create());
    }

    public static function random(): CategoryId
    {
        return self::create(UuidMother::create());
    }
}
