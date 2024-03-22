<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Domain;

use MyLibrary\Tests\Shared\Infrastructure\Mockery\MyLibraryMatcherIsSimilar;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\Constraint\MyLibraryConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar($expected, $actual): bool
    {
        $constraint = new MyLibraryConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function assertSimilar($expected, $actual): void
    {
        $constraint = new MyLibraryConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo($value, $delta = 0.0): MyLibraryMatcherIsSimilar
    {
        return new MyLibraryMatcherIsSimilar($value, $delta);
    }
}
