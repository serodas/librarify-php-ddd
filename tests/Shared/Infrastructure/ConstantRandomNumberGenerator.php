<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure;

use MyLibrary\Shared\Domain\RandomNumberGenerator;

final class ConstantRandomNumberGenerator implements RandomNumberGenerator
{
    public function generate(): int
    {
        return 1;
    }
}
