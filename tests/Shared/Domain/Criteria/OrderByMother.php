<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Domain\Criteria;

use MyLibrary\Shared\Domain\Criteria\OrderBy;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class OrderByMother
{
    public static function create(?string $fieldName = null): OrderBy
    {
        return new OrderBy($fieldName ?? WordMother::create());
    }
}
