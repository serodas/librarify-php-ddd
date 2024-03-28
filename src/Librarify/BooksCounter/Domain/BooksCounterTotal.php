<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Domain;

use MyLibrary\Shared\Domain\ValueObject\IntValueObject;

final class BooksCounterTotal extends IntValueObject
{
    public static function initialize(): self
    {
        return new self(0);
    }

    public function increment(): self
    {
        return new self($this->value() + 1);
    }
}