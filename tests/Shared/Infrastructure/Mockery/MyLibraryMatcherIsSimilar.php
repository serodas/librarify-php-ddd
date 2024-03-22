<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Mockery;

use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\Constraint\MyLibraryConstraintIsSimilar;
use Mockery\Matcher\MatcherAbstract;

final class MyLibraryMatcherIsSimilar extends MatcherAbstract
{
    private MyLibraryConstraintIsSimilar $constraint;

    public function __construct($value, $delta = 0.0)
    {
        parent::__construct($value);

        $this->constraint = new MyLibraryConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}
