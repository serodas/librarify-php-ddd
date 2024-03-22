<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Domain;

final class WordMother
{
    public static function create(): string
    {
        return MotherCreator::random()->word;
    }
}
