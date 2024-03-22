<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Domain\Criteria;

use MyLibrary\Shared\Domain\Criteria\FilterValue;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class FilterValueMother
{
    public static function create(?string $value = null): FilterValue
    {
        return new FilterValue($value ?? WordMother::create());
    }
}
