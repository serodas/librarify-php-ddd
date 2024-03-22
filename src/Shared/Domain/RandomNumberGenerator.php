<?php

declare(strict_types=1);

namespace MyLibrary\Shared\Domain;

interface RandomNumberGenerator
{
    public function generate(): int;
}
