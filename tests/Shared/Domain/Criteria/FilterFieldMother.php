<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Domain\Criteria;

use MyLibrary\Shared\Domain\Criteria\FilterField;
use MyLibrary\Tests\Shared\Domain\WordMother;

final class FilterFieldMother
{
    public static function create(?string $fieldName = null): FilterField
    {
        return new FilterField($fieldName ?? WordMother::create());
    }
}
