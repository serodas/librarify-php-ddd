<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Domain;

use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class CategoryNameMother
{
    public static function create(?string $value = null): CategoryName
    {
        return new CategoryName($value ?? WordMother::create());
    }
}
